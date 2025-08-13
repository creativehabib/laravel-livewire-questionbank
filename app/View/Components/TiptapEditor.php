<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TiptapEditor extends Component
{
    public ?string $value;

    public function __construct(?string $value = '')
    {
        $this->value = $value ?? '';
    }

    public function render(): View
    {
        return view('components.tiptap-editor');
    }
}
