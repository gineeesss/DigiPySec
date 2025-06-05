<div>
    <h2 class="text-xl font-semibold mb-4">Confirma tu cita</h2>

    <form wire:submit.prevent="reservarCita" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Tu email</label>
            <input type="email" wire:model.defer="email" class="w-full border rounded p-2" required />
        </div>

        <button type="submit" class="bg-black text-white px-4 py-2 rounded">
            Confirmar reserva
        </button>
    </form>
</div>
