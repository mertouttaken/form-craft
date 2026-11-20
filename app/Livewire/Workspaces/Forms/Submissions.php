<?php

namespace App\Livewire\Workspaces\Forms;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Submissions extends Component
{
    public function render(): View
    {
        return view('livewire.workspaces.forms.submissions', [
            'demoSubmission' => session()->get('formcraft.preview.aralik_submission'),
        ])
            ->extends('formcraft.submissions')
            ->section('page');
    }
}
