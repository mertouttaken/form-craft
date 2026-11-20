<?php

use App\Livewire\Workspaces\Forms\Create as FormCreate;
use App\Livewire\Workspaces\Forms\Edit as FormEdit;
use App\Livewire\Workspaces\Forms\Fields\Create as FieldCreate;
use App\Livewire\Workspaces\Forms\Fields\Index as FieldsIndex;
use App\Livewire\Workspaces\Forms\Index;
use App\Livewire\Workspaces\Settings\Members;
use App\Models\Fields;
use App\Models\Forms;
use App\Models\Invitations;
use App\Models\User;
use App\Models\Workspace_User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed();
    // The seeded free workspace is at its 3-form limit; make room for create tests.
    Forms::where('public_slug', 'stajyer-basvurusu')->delete();
});

$form = ['workspace' => 'deniz', 'form' => 'aralik-bulusmasi'];

test('creating a form saves a draft with an underscore link', function () {
    Livewire::test(FormCreate::class, ['workspace' => 'deniz'])
        ->set('title', 'Gezi Planı')
        ->call('save')
        ->assertRedirect(route('formcraft.preview.fields', ['workspace' => 'deniz', 'form' => 'gezi_plani']));

    expect(Forms::where('public_slug', 'gezi_plani')->value('status'))->toBe('draft');
});

test('a taken link gets a number', function () {
    Livewire::test(FormCreate::class, ['workspace' => 'deniz'])->set('title', 'Gezi Planı')->call('save');

    expect(Livewire::test(FormCreate::class, ['workspace' => 'deniz'])->set('title', 'Gezi Planı')->get('slug'))
        ->toBe('gezi_plani_2');
});

test('free plan stops at three forms', function () {
    Livewire::test(FormCreate::class, ['workspace' => 'deniz'])->set('title', 'Dördüncü form')->call('save')->assertHasNoErrors();

    Livewire::test(FormCreate::class, ['workspace' => 'deniz'])
        ->set('title', 'Beşinci form')
        ->call('save')
        ->assertHasErrors('title');

    expect(Forms::where('title', 'Beşinci form')->exists())->toBeFalse();
});

test('the forms list filters and searches the database', function () {
    Livewire::test(Index::class, ['workspace' => 'deniz'])
        ->assertSee('Aralık Buluşmasına kayıt')
        ->assertSee('Yaz okulu memnuniyet anketi')
        ->call('filter', 'closed')
        ->assertDontSee('Aralık Buluşmasına kayıt')
        ->call('filter', 'all')
        ->set('search', 'ARALIK')
        ->assertSee('Aralık Buluşmasına kayıt')
        ->assertDontSee('Yaz okulu memnuniyet anketi')
        ->assertSee(route('formcraft.preview.fields', ['workspace' => 'deniz', 'form' => 'aralik-bulusmasi']), false);
});

test('a form needs a title', function () {
    Livewire::test(FormCreate::class, ['workspace' => 'deniz'])
        ->call('save')
        ->assertHasErrors(['title' => 'required']);
});

test('form settings are saved', function () use ($form) {
    Livewire::test(FormEdit::class, $form)
        ->set('title', 'Aralık Buluşması')
        ->set('status', 'closed')
        ->set('redirectUrl', 'not a url')
        ->call('save')
        ->assertHasErrors('redirectUrl')
        ->set('redirectUrl', 'https://ornek.com/tesekkurler')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('saved', true);

    $saved = Forms::where('public_slug', 'aralik-bulusmasi')->first();
    expect($saved->title)->toBe('Aralık Buluşması')
        ->and($saved->status)->toBe('closed')
        ->and(json_decode($saved->settings, true)['redirect_url'])->toBe('https://ornek.com/tesekkurler');
});

test('a choice field needs two options and is added last', function () use ($form) {
    Livewire::test(FieldCreate::class, $form)
        ->set('type', 'radio')
        ->set('label', 'Ulaşım')
        ->set('options', ['Otobüs', ''])
        ->call('save')
        ->assertHasErrors('options')
        ->set('options', ['Otobüs', 'Araba'])
        ->call('save')
        ->assertRedirect(route('formcraft.preview.fields', $form));

    $field = Fields::where('label', 'Ulaşım')->first();
    expect($field->position)->toBe(7)
        ->and(json_decode($field->options, true))->toBe(['Otobüs', 'Araba']);
});

test('free plan stops at ten fields', function () use ($form) {
    $formId = Forms::where('public_slug', 'aralik-bulusmasi')->value('id');
    foreach (range(7, 10) as $position) {
        Fields::create(['form_id' => $formId, 'type' => 'text', 'label' => "Alan {$position}", 'is_required' => false, 'position' => $position]);
    }

    Livewire::test(FieldCreate::class, $form)
        ->set('label', 'On birinci')
        ->call('save')
        ->assertHasErrors('label');

    expect(Fields::where('form_id', $formId)->count())->toBe(10);
});

test('fields move and delete', function () use ($form) {
    $formId = Forms::where('public_slug', 'aralik-bulusmasi')->value('id');
    $first = Fields::where('form_id', $formId)->where('position', 1)->first();

    Livewire::test(FieldsIndex::class, $form)->call('moveDown', $first->id);
    expect($first->fresh()->position)->toBe(2);

    Livewire::test(FieldsIndex::class, $form)->call('delete', $first->id);
    expect(Fields::where('form_id', $formId)->orderBy('position')->pluck('position')->all())->toBe([1, 2, 3, 4, 5]);
});

test('members can be re-roled, removed and invited', function () {
    $mert = User::where('email', 'mert@ornek.com')->first();
    $deniz = User::where('email', 'deniz@ornek.com')->first();

    $component = Livewire::test(Members::class, ['workspace' => 'deniz'])
        ->call('updateRole', $mert->id, 'editor');
    expect(Workspace_User::where('user_id', $mert->id)->whereHas('workspace', fn ($q) => $q->where('slug', 'deniz'))->value('role'))->toBe('editor');

    expect(fn () => $component->call('removeMember', $deniz->id))->toThrow(ModelNotFoundException::class);

    $component->call('removeMember', $mert->id);
    expect(Workspace_User::where('user_id', $mert->id)->count())->toBe(0);

    Livewire::test(Members::class, ['workspace' => 'deniz'])
        ->set('inviteEmail', 'ece@ornek.com')
        ->call('invite')
        ->assertHasErrors('inviteEmail')
        ->set('inviteEmail', 'yeni@ornek.com')
        ->set('inviteRole', 'viewer')
        ->call('invite')
        ->assertHasNoErrors();

    expect(Invitations::where('email', 'yeni@ornek.com')->value('role'))->toBe('viewer');
});

test('a new account gets its own workspace and header links point to it', function () {
    $user = User::factory()->create(['name' => 'Yeni Kullanıcı']);

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertOk()
        ->assertSee(route('formcraft.preview.forms', ['workspace' => 'yeni-kullanici']), false)
        ->assertDontSee('/w/deniz/forms', false);

    expect($user->workspaces()->first()->pivot->role)->toBe('owner');
});
