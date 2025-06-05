<?php
// app/Livewire/Demos/Barberia/CalendarSelector.php
namespace App\Livewire\Demos\Barberia;

use Livewire\Component;
use Carbon\Carbon;

class CalendarSelector extends Component
{
    public $currentMonth;
    public $nextMonth;
    public $selectedDate = null;
    public $weeksCurrent = [];
    public $weeksNext = [];
    public $disabledDates = [];

    public function mount()
    {
        $this->currentMonth = now();
        $this->nextMonth = now()->addMonth();
        $this->generateCalendar();
        $this->disabledDates = $this->getDisabledDates();
    }

    public function generateCalendar()
    {
        $this->weeksCurrent = $this->buildCalendar($this->currentMonth);
        $this->weeksNext = $this->buildCalendar($this->nextMonth);
    }

    private function buildCalendar($month)
    {
        $startOfMonth = $month->copy()->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();

        $startDay = $startOfMonth->copy()->startOfWeek();
        $endDay = $endOfMonth->copy()->endOfWeek();

        $calendar = [];
        $currentDay = $startDay->copy();

        while ($currentDay <= $endDay) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $week[] = [
                    'day' => $currentDay->day,
                    'date' => $currentDay->copy(),
                    'isCurrentMonth' => $currentDay->month == $month->month,
                    'isToday' => $currentDay->isToday(),
                    'isPast' => $currentDay->isPast(),
                    'isDisabled' => $currentDay->isPast() || in_array($currentDay->toDateString(), $this->disabledDates),
                ];
                $currentDay->addDay();
            }
            $calendar[] = $week;
        }

        return $calendar;
    }

    private function getDisabledDates()
    {
        // Aquí puedes añadir lógica para deshabilitar días específicos
        // Por ejemplo, días festivos o días sin disponibilidad
        return [];
    }


    public function selectDate($dateString)
    {
        $date = Carbon::parse($dateString);

        if (!$date->isPast() && !in_array($date->toDateString(), $this->disabledDates)) {
            $this->selectedDate = $dateString;
            $this->dispatch('dateSelected', date: $dateString);
        }
    }

    public function confirmDate()
    {
        if ($this->selectedDate) {
            $this->dispatch('date-selected', date: $this->selectedDate)->to(Reservar::class);
            return true;
        }
        return false;
    }
    public function render()
    {
        return view('livewire.demos.barberia.calendar-selector');
    }
}
