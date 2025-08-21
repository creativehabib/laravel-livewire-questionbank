<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class MessageRetentionSettings extends Component
{
    public $retentionHours;

    protected $rules = [
        'retentionHours' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->retentionHours = Setting::get('message_retention_hours', 24);
    }

    public function save()
    {
        $this->validate();
        Setting::set('message_retention_hours', $this->retentionHours);
        session()->flash('message', 'Retention time updated.');
    }

    public function render()
    {
        return view('livewire.admin.message-retention-settings');
    }
}
