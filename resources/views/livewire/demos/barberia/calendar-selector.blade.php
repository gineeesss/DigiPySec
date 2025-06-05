<!-- resources/views/livewire/demos/barberia/calendar-selector.blade.php -->
<div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Mes actual -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gray-800 text-white px-4 py-2 text-center">
                <h3 class="font-semibold">{{ $currentMonth->translatedFormat('F Y') }}</h3>
            </div>
            <div class="p-2">
                <div class="grid grid-cols-7 gap-1 text-center text-xs font-medium text-gray-500 mb-2">
                    @foreach(['L', 'M', 'X', 'J', 'V', 'S', 'D'] as $day)
                        <div>{{ $day }}</div>
                    @endforeach
                </div>
                <div class="grid grid-cols-7 gap-1">
                    @foreach($weeksCurrent as $week)
                        @foreach($week as $day)
                            @php
                                $isSelectable = $day['isCurrentMonth'] && !$day['isPast'] && !$day['isDisabled'];
                                $isSelected = $selectedDate === $day['date']->toDateString();
                            @endphp
                            <button
                                @if($isSelectable)
                                    wire:click="selectDate('{{ $day['date']->toDateString() }}')"
                                @endif
                                class="py-2 rounded-full text-center text-sm
                                    {{ $day['isCurrentMonth'] ? 'text-gray-900' : 'text-gray-400' }}
                                    {{ $day['isToday'] ? 'font-bold' : '' }}
                                    {{ $isSelected ? 'bg-blue-600 text-white' : '' }}
                                    {{ $isSelectable ? 'hover:bg-blue-100 cursor-pointer' : 'cursor-not-allowed opacity-50' }}
                                    {{ $day['isPast'] ? 'line-through' : '' }}"
                            >
                                {{ $day['day'] }}
                            </button>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Próximo mes -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gray-800 text-white px-4 py-2 text-center">
                <h3 class="font-semibold">{{ $nextMonth->translatedFormat('F Y') }}</h3>
            </div>
            <div class="p-2">
                <div class="grid grid-cols-7 gap-1 text-center text-xs font-medium text-gray-500 mb-2">
                    @foreach(['L', 'M', 'X', 'J', 'V', 'S', 'D'] as $day)
                        <div>{{ $day }}</div>
                    @endforeach
                </div>
                <div class="grid grid-cols-7 gap-1">
                    @foreach($weeksNext as $week)
                        @foreach($week as $day)
                            @php
                                $isSelectable = $day['isCurrentMonth'] && !$day['isPast'] && !$day['isDisabled'];
                                $isSelected = $selectedDate === $day['date']->toDateString();
                            @endphp
                            <button
                                @if($isSelectable)
                                    wire:click="selectDate('{{ $day['date']->toDateString() }}')"
                                @endif
                                class="py-2 rounded-full text-center text-sm
                                    {{ $day['isCurrentMonth'] ? 'text-gray-900' : 'text-gray-400' }}
                                    {{ $day['isToday'] ? 'font-bold' : '' }}
                                    {{ $isSelected ? 'bg-blue-600 text-white' : '' }}
                                    {{ $isSelectable ? 'hover:bg-blue-100 cursor-pointer' : 'cursor-not-allowed opacity-50' }}
                                    {{ $day['isPast'] ? 'line-through' : '' }}"
                            >
                                {{ $day['day'] }}
                            </button>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if($selectedDate)
        <div class="mt-4 text-center text-sm text-green-600">
            Fecha seleccionada: {{ Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d \d\e F \d\e Y') }}
        </div>

        <div class="mt-6 text-center">
            <button
                wire:click="confirmDate"
                wire:loading.attr="disabled"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
                <span wire:loading.remove>Confirmar fecha y continuar</span>
                <span wire:loading>Cargando...</span>
                <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    @endif
</div>
