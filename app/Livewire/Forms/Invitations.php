<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class Invitations extends Component
{
    public function render()
    {
        return view('livewire.forms.invitations')
            ->extends('formcraft.invitation')
            ->section('page');
    }
}
