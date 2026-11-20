<?php

use App\Livewire\Forms\Index as PublicForm;
use App\Livewire\Forms\Invitations;
use App\Livewire\Forms\Thanks;
use App\Livewire\Profile;
use App\Livewire\Welcome;
use App\Livewire\Workspaces\Forms\Builder;
use App\Livewire\Workspaces\Forms\Create as FormCreate;
use App\Livewire\Workspaces\Forms\Edit as FormEdit;
use App\Livewire\Workspaces\Forms\Fields\Create as FieldCreate;
use App\Livewire\Workspaces\Forms\Fields\Index as FieldsIndex;
use App\Livewire\Workspaces\Forms\Index as FormsIndex;
use App\Livewire\Workspaces\Forms\Submissions;
use App\Livewire\Workspaces\Settings\Members;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('formcraft.home');

Route::get('dashboard', FormsIndex::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('profile', Profile::class)
    ->middleware(['auth'])
    ->name('profile');

/*
 * Workspace pages, in the URL shape from the project brief.
 * Links without explicit parameters fall back to the seeded sample
 * (see AppServiceProvider::configureSampleUrls).
 */
Route::prefix('w/{workspace}')->name('formcraft.preview.')->group(function () {
    Route::get('forms', FormsIndex::class)->name('forms');
    Route::get('forms/create', FormCreate::class)->name('form-create');
    Route::get('forms/{form}/edit', FormEdit::class)->name('form-edit');
    Route::get('forms/{form}/builder', Builder::class)->name('builder');
    Route::get('forms/{form}/fields', FieldsIndex::class)->name('fields');
    Route::get('forms/{form}/fields/create', FieldCreate::class)->name('field-create');
    Route::get('forms/{form}/submissions', Submissions::class)->name('submissions');
    Route::get('settings/members', Members::class)->name('members');
});

/*
 * Public pages: no auth.
 */
Route::name('formcraft.preview.')->group(function () {
    Route::get('f/{public_slug}', PublicForm::class)->name('public-form');
    Route::get('f/{public_slug}/thanks', Thanks::class)->name('thanks');
    Route::get('invitations/{token}', Invitations::class)->name('invitation');
});

require __DIR__.'/auth.php';
