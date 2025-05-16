<div>
    <!-- Área de mensajes -->
    <div
        class="chat-messages h-64 overflow-y-auto border p-4 mb-4"
        id="messages-container"
    >
        @foreach($messages as $msg)
            <div class="message mb-2 p-2 bg-gray-100 rounded">{{ $msg }}</div>
        @endforeach
    </div>

    <!-- Formulario de envío -->
    <div class="flex">
        <input
            wire:model="message"
            wire:keydown.enter="sendMessage"
            type="text"
            placeholder="Escribe tu mensaje..."
            class="flex-1 border p-2 rounded-l"
        >
        <button
            wire:click="sendMessage"
            class="bg-blue-500 text-white p-2 rounded-r"
        >
            Enviar
        </button>
    </div>

    <!-- Script de actualización -->
    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                // Escucha el evento con el nuevo nombre
                window.Echo.channel('chat')
                    .listen('.message.sent', (e) => {
                        Livewire.dispatch('new-message', { message: e.message });
                    });
            });
        </script>
    @endpush
</div>
