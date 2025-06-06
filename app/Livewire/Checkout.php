<?php

namespace App\Livewire;

use DB;
use Livewire\Component;
use App\Models\Address;
use App\Models\PaymentMethod;
use App\Models\SolicitudServicio;
use Illuminate\Support\Facades\Auth;

class Checkout extends Component
{
    public $carrito = [];
    public $total = 0;

    // Dirección de facturación
    public $userAddresses = [];
    public $selectedBillingAddress = null;
    public $billingAddress = [
        'contact_name' => '',
        'street' => '',
        'city' => '',
        'state' => '',
        'zip_code' => '',
        'country' => 'España',
        'contact_phone' => '',
    ];

    // Métodos de pago
    public $userPaymentMethods = [];
    public $selectedPaymentMethod = null;
    public $newPaymentMethod = [
        'type' => '',
        'card_holder' => '',
        'card_number' => '',
        'expiry_month' => '',
        'expiry_year' => '',
        'bank_name' => '',
        'account_number' => '',
    ];

    protected $listeners = ['carritoActualizado' => 'actualizarCarrito'];

    public function mount()
    {
        $this->carrito = session()->get('carrito', []);
        $this->calcularTotal();

        // Cargar direcciones y métodos de pago del usuario
        if (Auth::check()) {
            $this->userAddresses = Auth::user()->addresses()->where('type', 'billing')->orWhere('type', 'both')->get();
            $this->userPaymentMethods = Auth::user()->paymentMethods()->get();

            // Cargar dirección por defecto si existe
            $defaultAddress = Auth::user()->addresses()->where('is_default', true)->first();
            if ($defaultAddress) {
                $this->selectedBillingAddress = $defaultAddress->id;
                $this->cargarDireccionSeleccionada();
            }
        }
    }

    public function actualizarCarrito($carrito)
    {
        $this->carrito = $carrito;
        $this->calcularTotal();
    }

    public function calcularTotal()
    {
        $this->total = array_reduce($this->carrito, function($carry, $item) {
            return $carry + $item['precio'];
        }, 0);
    }

    public function cargarDireccionSeleccionada()
    {
        if ($this->selectedBillingAddress) {
            $address = Address::find($this->selectedBillingAddress);
            $this->billingAddress = [
                'contact_name' => $address->contact_name,
                'street' => $address->street,
                'city' => $address->city,
                'state' => $address->state,
                'zip_code' => $address->zip_code,
                'country' => $address->country,
                'contact_phone' => $address->contact_phone,
            ];
        }
    }

    public function useDefaultBillingAddress()
    {
        if (Auth::check()) {
            $defaultAddress = Auth::user()->addresses()->where('is_default', true)->first();
            if ($defaultAddress) {
                $this->selectedBillingAddress = $defaultAddress->id;
                $this->cargarDireccionSeleccionada();
            }
        }
    }

    public function confirmarPedido()
    {
        $this->validate([
            'billingAddress.contact_name' => 'required',
            'billingAddress.street' => 'required',
            'billingAddress.city' => 'required',
            'billingAddress.zip_code' => 'required',
            'newPaymentMethod.type' => 'required',
        ]);

        $client = DB::transaction(function () {
            $user = Auth::user();

            // Si no existe cliente, lo creamos con datos básicos
            if (!$user->client) {
                return $user->client()->create([
                    'phone' => $this->billingAddress['contact_phone'] ?? null,
                    'company_name' => $this->billingAddress['company_name'] ?? null,
                    'tax_id' => $this->billingAddress['tax_id'] ?? null
                ]);
            }

            return $user->client;
        });

        // Crear la solicitud de servicio ahora que $cliente existe
        $solicitud = SolicitudServicio::create([
            'cliente_id' => $client->id,
            'user_id' => null,
            'estado' => 'pendiente',
            'total' => $this->total,
            'notas' => 'Dirección de facturación: ' . $this->billingAddress['street'] . ', ' . $this->billingAddress['city'],
        ]);

        // Añadir items a la solicitud
        foreach ($this->carrito as $item) {
            $solicitud->items()->create([
                'servicio_id' => $item['id'],
                'cantidad' => 1,
                'precio_unitario' => $item['precio'],
                'opciones_personalizacion' => $item['opciones'] ?? null,
            ]);
        }

        // Guardar método de pago si es nuevo
        if ($this->selectedPaymentMethod) {
            $paymentMethod = PaymentMethod::find($this->selectedPaymentMethod);
        } else {
            $paymentData = [
                'user_id' => Auth::id(),
                'type' => $this->newPaymentMethod['type'],
                'alias' => 'Método usado en pedido #' . $solicitud->id,
            ];

            if ($this->newPaymentMethod['type'] === 'credit_card') {
                $paymentData['card_holder'] = $this->newPaymentMethod['card_holder'];
                $paymentData['card_number'] = $this->newPaymentMethod['card_number'];
                $paymentData['expiry_month'] = $this->newPaymentMethod['expiry_month'];
                $paymentData['expiry_year'] = $this->newPaymentMethod['expiry_year'];
                $paymentData['last_four'] = substr($this->newPaymentMethod['card_number'], -4);
            } elseif ($this->newPaymentMethod['type'] === 'bank_transfer') {
                $paymentData['bank_name'] = $this->newPaymentMethod['bank_name'];
                $paymentData['account_number'] = $this->newPaymentMethod['account_number'];
            }

            $paymentMethod = PaymentMethod::create($paymentData);
        }

        // Limpiar carrito
        session()->forget('carrito');
        $this->carrito = [];
        $this->dispatch('carritoActualizado', $this->carrito);

        // Redirigir a confirmación
        return redirect()->route('solicitud.show', $solicitud->id)
            ->with('success', 'Pedido realizado con éxito. Número de pedido: #' . $solicitud->id);
    }

    public function render()
    {
        return view('livewire.checkout')->layout('layouts.app');
    }
}
