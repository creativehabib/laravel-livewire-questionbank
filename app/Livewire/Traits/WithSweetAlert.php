<?php

namespace App\Livewire\Traits;

trait WithSweetAlert
{
    public function alert($type, $title, $text = '', $timer = null, $showConfirmButton = true)
    {
        $this->dispatch('swal:alert', [
            'type' => $type,
            'title' => $title,
            'text' => $text,
            'timer' => $timer,
            'showConfirmButton' => $showConfirmButton
        ]);
    }

    public function confirm($title, $text, $method, $params = [], $type = 'warning')
    {
        $this->dispatch('swal:confirm', [
            'type' => $type,
            'title' => $title,
            'text' => $text,
            'method' => $method,
            'params' => $params
        ]);
    }
}
