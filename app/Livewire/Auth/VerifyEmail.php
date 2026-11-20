<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class VerifyEmail extends Component
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function mount(): void
    {
        $request = app(EmailVerificationRequest::class);

        if (! $request->user()->hasVerifiedEmail() && $request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        $this->redirectIntended(default: route('dashboard', absolute: false).'?verified=1');
    }

    public function render(): string
    {
        return '<div></div>';
    }
}
