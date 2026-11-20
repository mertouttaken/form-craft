@php
  $icons = [
    'text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16M4 12h10"/></svg>',
    'textarea' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6h16M4 10h16M4 14h16M4 18h9"/></svg>',
    'email' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14"/><path d="m3 7 9 6 9-6"/></svg>',
    'number' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4 7 20M17 4l-2 16M4 9h17M3 15h17"/></svg>',
    'select' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="6" width="18" height="12"/><path d="m14 11 2.5 2.5L19 11"/></svg>',
    'radio' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="7" cy="8" r="3"/><circle cx="7" cy="16" r="3"/><circle cx="7" cy="8" r="1" fill="currentColor"/><path d="M13 8h8M13 16h8"/></svg>',
    'checkbox' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="5" width="6" height="6"/><rect x="4" y="13" width="6" height="6"/><path d="m5.5 8 1.5 1.5L9 7M13 8h8M13 16h8"/></svg>',
    'date' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>',
  ];
@endphp
<main class="wrap">
  <p class="crumbs"><a href="{{ route('formcraft.preview.forms', ['workspace' => $this->workspaceModel->slug]) }}">Formlar</a> / <a href="{{ route('formcraft.preview.fields', $this->formRoute) }}">{{ $form->title }}</a> / <span>Yeni alan</span></p>
  <form class="paper sheet" wire:submit="save" novalidate>
    <span class="serial">Alan No {{ str_pad($nextNumber, 2, '0', STR_PAD_LEFT) }}</span>
    <h1 class="d-lg" style="margin-bottom:2rem">Yeni alan</h1>

    <section class="step" data-fc-in>
      <h2><b>01</b>Alan tipi</h2>
      <div class="types">
        @foreach (\App\Livewire\Workspaces\Forms\Fields\Create::TYPES as $value => [$typeLabel, $hint])
          <label wire:key="type-{{ $value }}"><input type="radio" name="type" value="{{ $value }}" wire:model.live="type">{!! $icons[$value] !!}<b>{{ $typeLabel }}</b><small>{{ $hint }}</small></label>
        @endforeach
      </div>
    </section>

    <section class="step" data-fc-in>
      <h2><b>02</b>Soru</h2>
      <div class="grid2">
        <div @class(['field', 'field--error' => $errors->has('label')]) style="grid-column:1/-1"><label class="lbl" for="l">Etiket</label><input class="input" id="l" wire:model="label" maxlength="150" required>
          @error('label')<p class="field__error">{{ $message }}</p>@enderror</div>
        <div class="field"><label class="lbl" for="p">Yer tutucu</label><input class="input" id="p" wire:model="placeholder" maxlength="150" placeholder="Örn. Deniz Yılmaz"></div>
        <div class="field"><label class="lbl" for="h">Yardım metni</label><input class="input" id="h" wire:model="helpText" maxlength="255" placeholder="Alanın altında küçük yazı"></div>
        <label class="check" style="grid-column:1/-1"><input type="checkbox" wire:model="isRequired"> Zorunlu alan</label>
      </div>
    </section>

    @if ($this->isChoice())
      <section class="step" wire:key="step-options">
        <h2><b>03</b>Seçenekler <span class="lbl muted" style="font-size:.7rem">· en az iki</span></h2>
        <div class="opts">
          @foreach ($options as $index => $option)
            <div class="opt" wire:key="option-{{ $index }}"><span class="field__no">{{ chr(65 + $index) }}</span><input class="input" wire:model="options.{{ $index }}" maxlength="100" aria-label="Seçenek {{ chr(65 + $index) }}"><button type="button" class="x" wire:click="removeOption({{ $index }})" aria-label="Seçenek {{ chr(65 + $index) }} sil">×</button></div>
          @endforeach
          @error('options')<p class="field__error">{{ $message }}</p>@enderror
          @error('options.*')<p class="field__error">{{ $message }}</p>@enderror
          <button type="button" class="btn btn--sm btn--ghost" style="justify-self:start;margin-top:.5rem" wire:click="addOption">+ Seçenek ekle</button>
        </div>
      </section>
    @endif

    @if (in_array($type, ['text', 'textarea', 'number'], true))
      <section class="step" wire:key="step-rules">
        <h2><b>{{ $this->isChoice() ? '04' : '03' }}</b>Kurallar <span class="lbl muted" style="font-size:.7rem">· isteğe bağlı</span></h2>
        <div class="rules">
          <div @class(['field', 'field--error' => $errors->has('min')])><label class="lbl" for="mn">En az</label><input class="input" id="mn" wire:model="min" inputmode="numeric" placeholder="1">
            @error('min')<p class="field__error">{{ $message }}</p>@enderror</div>
          <div @class(['field', 'field--error' => $errors->has('max')])><label class="lbl" for="mx">En çok</label><input class="input" id="mx" wire:model="max" inputmode="numeric" placeholder="4">
            @error('max')<p class="field__error">{{ $message }}</p>@enderror</div>
          @if ($type !== 'number')
            <div @class(['field', 'field--error' => $errors->has('pattern')])><label class="lbl" for="rx">Desen (regex)</label><input class="input" id="rx" wire:model="pattern" placeholder="/^[0-9]{11}$/">
              @error('pattern')<p class="field__error">{{ $message }}</p>@enderror</div>
          @endif
        </div>
        <p class="field__help" style="margin-top:1rem">Sayı alanında değer sınırı, metin alanında karakter sınırı olarak uygulanır.</p>
      </section>
    @endif

    <div class="submit"><a class="btn btn--ghost" href="{{ route('formcraft.preview.fields', $this->formRoute) }}">Vazgeç</a><button class="btn btn--stamp" type="submit" wire:loading.attr="disabled" wire:target="save">Alanı kaydet</button></div>
  </form>
</main>
