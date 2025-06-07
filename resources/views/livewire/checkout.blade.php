<!-- resources/views/livewire/checkout.blade.php -->
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Finalizar Compra</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Sección de dirección de facturación -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Dirección de Facturación</h2>

            @if($userAddresses->count() > 0)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar dirección guardada</label>
                    <select wire:model="selectedBillingAddress" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Seleccione una dirección</option>
                        @foreach($userAddresses as $address)
                            <option value="{{ $address->id }}">{{ $address->street }}, {{ $address->city }}</option>
                        @endforeach
                    </select>
                    <button wire:click="useDefaultBillingAddress" class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                        Usar mi dirección principal
                    </button>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre de contacto</label>
                    <input type="text" wire:model="billingAddress.contact_name" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Calle</label>
                    <input type="text" wire:model="billingAddress.street" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ciudad</label>
                        <input type="text" wire:model="billingAddress.city" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Código Postal</label>
                        <input type="text" wire:model="billingAddress.zip_code" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Teléfono de contacto</label>
                    <input type="text" wire:model="billingAddress.contact_phone" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
        </div>

        <!-- Sección de método de pago -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Método de Pago</h2>

            @if($userPaymentMethods->count() > 0)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar método guardado</label>
                    <select wire:model="selectedPaymentMethod" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Seleccione un método</option>
                        @foreach($userPaymentMethods as $method)
                            <option value="{{ $method->id }}">
                                {{ ucfirst($method->type) }}
                                @if($method->type === 'credit_card') (****{{ $method->last_four }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de pago</label>
                    <select wire:model="newPaymentMethod.type" id="payment-type" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Seleccione un tipo</option>
                        <option value="credit_card">Tarjeta de crédito</option>
                        <option value="paypal">PayPal</option>
                        <option value="bank_transfer">Transferencia bancaria</option>
                        <option value="cash">Efectivo</option>
                    </select>

                </div>

                <!-- Campos para tarjeta de crédito -->
                <div id="credit_card-fields" class="payment-fields hidden">
                    <input type="text" wire:model="newPaymentMethod.card_number" placeholder="Número de tarjeta" class="w-full border-gray-300 rounded-md shadow-sm mt-2">
                    <input type="text" wire:model="newPaymentMethod.expiration_date" placeholder="Fecha de expiración" class="w-full border-gray-300 rounded-md shadow-sm mt-2">
                    <input type="text" wire:model="newPaymentMethod.cvv" placeholder="CVV" class="w-full border-gray-300 rounded-md shadow-sm mt-2">
                </div>

                <!-- Campos para PayPal -->
                <div id="paypal-fields" class="payment-fields hidden">
                    <input type="email" wire:model="newPaymentMethod.paypal_email" placeholder="Correo de PayPal" class="w-full border-gray-300 rounded-md shadow-sm mt-2">
                </div>

                <!-- Campos para transferencia -->
                <div id="bank_transfer-fields" class="payment-fields hidden">
                    <input type="text" wire:model="newPaymentMethod.iban" placeholder="IBAN" class="w-full border-gray-300 rounded-md shadow-sm mt-2">
                </div>

                <!-- Mensaje para efectivo -->
                <div id="cash-fields" class="payment-fields hidden">
                    <p class="text-gray-600 mt-2">El pago en efectivo se realizará en la entrega.</p>
                </div>


                {{-- Campos condicionales según el tipo de pago --}}
                @if($newPaymentMethod['type'] === 'credit_card')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Número de tarjeta</label>
                        <input type="text" wire:model="newPaymentMethod.card_number" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de expiración</label>
                        <input type="text" wire:model="newPaymentMethod.expiration_date" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">CVV</label>
                        <input type="text" wire:model="newPaymentMethod.cvv" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                @elseif($newPaymentMethod['type'] === 'paypal')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Correo de PayPal</label>
                        <input type="email" wire:model="newPaymentMethod.paypal_email" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                @elseif($newPaymentMethod['type'] === 'bank_transfer')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">IBAN</label>
                        <input type="text" wire:model="newPaymentMethod.iban" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                @elseif($newPaymentMethod['type'] === 'cash')
                    <p class="text-gray-600">El pago en efectivo se realizará en la entrega.</p>
                @endif

            </div>
        </div>
    </div>

    <!-- Resumen del pedido -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Resumen de tu pedido</h2>

        <div class="divide-y divide-gray-200">
            @foreach($carrito as $item)
                <div class="py-4 flex justify-between">
                    <div>
                        <p class="font-medium">{{ $item['nombre'] }}</p>
                        <p class="text-sm text-gray-500">${{ number_format($item['precio'], 2) }}</p>
                    </div>
                    <p class="font-medium">${{ number_format($item['precio'], 2) }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex justify-between text-lg font-bold">
                <span>Total:</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>
        </div>

        <div class="mt-6">
            <button
                wire:click="confirmarPedido"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-md font-medium"
            >
                Confirmar Pedido
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('payment-type');
        const allFields = document.querySelectorAll('.payment-fields');

        const toggleFields = (type) => {
            allFields.forEach(div => div.classList.add('hidden'));
            if (type) {
                const selectedDiv = document.getElementById(`${type}-fields`);
                if (selectedDiv) selectedDiv.classList.remove('hidden');
            }
        };

        select.addEventListener('change', function () {
            toggleFields(this.value);
        });

        // Si Livewire recarga la vista, vuelve a aplicar la lógica
        toggleFields(select.value);
    });
</script>
