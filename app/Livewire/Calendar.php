<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class Calendar extends Component
{
    public $events = [];
    public $eventId, $title, $label, $start, $end, $description;

    public function mount()
    {
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $this->events = Event::select('id', 'title', 'label', 'start', 'end', 'description')
            ->get()
            ->toArray();
    }

    public function addEvent()
    {
        $event = Event::create([
            'title' => $this->title,
            'label' => $this->label,
            'start' => $this->start,
            'end' => $this->end,
            'description' => $this->description,
        ]);

        $this->resetForm();
        $this->loadEvents();
        $this->dispatch('eventAdded', $event);
    }

    public function updateEvent()
    {
        $event = Event::find($this->eventId);
        $event->update([
            'title' => $this->title,
            'label' => $this->label,
            'start' => $this->start,
            'end' => $this->end,
            'description' => $this->description,
        ]);

        $this->resetForm();
        $this->loadEvents();
        $this->dispatch('eventUpdated', $event);
    }

    public function deleteEvent($id)
    {
        Event::findOrFail($id)->delete();
        $this->loadEvents();
        $this->dispatch('eventDeleted', $id);
    }

    public function resetForm()
    {
        $this->title = $this->label = $this->start = $this->end = $this->eventId = null;
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
