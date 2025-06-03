<div class="chatbot-container bg-white rounded-lg shadow-lg p-4 max-w-md mx-auto">
    <div class="chat-header bg-blue-600 text-white p-3 rounded-t-lg">
        <h3 class="font-bold">Asistente Virtual</h3>
        <p class="text-sm">¿En qué puedo ayudarte hoy?</p>
    </div>

    <div class="chat-messages h-64 overflow-y-auto p-3 space-y-2">
        @foreach($messages as $message)
            <div class="@if($message['role'] === 'user') text-right @endif mb-2">
                <div class="@if($message['role'] === 'user') bg-blue-100 text-blue-900 @else bg-gray-100 text-gray-900 @endif inline-block p-2 rounded-lg max-w-xs">
                    {{ $message['content'] }}
                </div>
            </div>
        @endforeach

        @if($isLoading)
            <div class="text-center">
                <svg class="animate-spin h-5 w-5 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        @endif
    </div>

    <div class="chat-input mt-3">
        <form wire:submit.prevent="sendMessage" class="flex">
            <input
                type="text"
                wire:model="userInput"
                placeholder="Escribe tu pregunta..."
                class="flex-1 border border-gray-300 rounded-l-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                @if($isLoading) disabled @endif
            >
            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                @if($isLoading) disabled @endif
            >
                Enviar
            </button>
        </form>
    </div>
</div>
