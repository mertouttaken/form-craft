<?php

namespace App\Livewire\Forms;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Thanks extends Component
{
    public function render(): View
    {
        return view('livewire.forms.thanks', [
            'demoSubmission' => session()->get('formcraft.preview.aralik_submission'),
        ]);
    }
}
