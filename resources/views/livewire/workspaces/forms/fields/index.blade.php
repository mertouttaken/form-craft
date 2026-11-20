<main class="wrap">
  <p class="crumbs"><a href="{{ route('formcraft.preview.forms', ['workspace' => $this->workspaceModel->slug]) }}">Formlar</a> / <span>{{ $form->title }}</span></p>
  <div class="pagehead">
    <h1 class="d-lg">{{ $form->title }}</h1>
    <div style="display:flex;gap:.75rem;flex-wrap:wrap">
      <a class="btn btn--ghost" href="{{ route('formcraft.preview.builder', $this->formRoute) }}">Canlı form kurucu ↗</a>
      <a class="btn btn--ghost" href="{{ route('formcraft.preview.public-form', ['public_slug' => $form->public_slug]) }}">Önizle</a>
      @if ($isFree && $fields->count() >= $limit)
        <span class="btn btn--stamp" aria-disabled="true" style="opacity:.5" title="Ücretsiz planda en fazla {{ $limit }} alan">+ Yeni alan</span>
      @else
        <a class="btn btn--stamp" href="{{ route('formcraft.preview.field-create', $this->formRoute) }}">+ Yeni alan</a>
      @endif
    </div>
  </div>
  <nav class="tabs" aria-label="Form"><a href="{{ route('formcraft.preview.form-edit', $this->formRoute) }}">Ayarlar</a><a href="{{ route('formcraft.preview.fields', $this->formRoute) }}" aria-current="page">Alanlar · {{ $fields->count() }}</a><a href="{{ route('formcraft.preview.submissions', $this->formRoute) }}">Yanıtlar · {{ $submissionCount }}</a></nav>

  <div class="paper sheet" data-fc-in>
    <div class="sheet__head"><span class="lbl">Alanlar · görünme sırasıyla</span><span @class(['stamp', $status[2]]) data-stamp style="font-size:.85rem">{{ $status[0] }}</span></div>
    <ol class="rows">
      @forelse ($fields as $field)
        <li class="row" wire:key="field-{{ $field->id }}"><span class="row__no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><div><div class="row__label">{{ $field->label }}</div><div class="row__ph">{{ \App\Livewire\Workspaces\Forms\Fields\Index::summary($field) }}</div></div><span class="type">{{ \App\Livewire\Workspaces\Forms\Fields\Create::TYPES[$field->type][0] ?? $field->type }}</span><span class="req-col">@if ($field->is_required)<span class="req">Zorunlu</span>@else<span class="opt">İsteğe bağlı</span>@endif</span>
          <div class="acts">
            <form wire:submit="moveUp({{ $field->id }})"><button class="sq" type="submit" @disabled($loop->first) aria-label="{{ $field->label }} yukarı taşı"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 15 6-6 6 6"/></svg></button></form>
            <form wire:submit="moveDown({{ $field->id }})"><button class="sq" type="submit" @disabled($loop->last) aria-label="{{ $field->label }} aşağı taşı"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg></button></form>
            <form wire:submit="delete({{ $field->id }})" wire:confirm="“{{ $field->label }}” alanı ve bu alana verilen cevaplar silinsin mi?"><button class="sq sq--danger" type="submit" aria-label="{{ $field->label }} sil"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 7h14M10 7V4h4v3M7 7l1 13h8l1-13"/></svg></button></form>
          </div></li>
      @empty
        <li class="row"><span class="row__no">00</span><div><div class="row__label">Henüz alan yok</div><div class="row__ph">İlk soruyu “Yeni alan” ile ekle.</div></div></li>
      @endforelse
    </ol>
    @if ($isFree)
      <div class="limit"><span class="lbl">Alan limiti</span><span class="meter" aria-hidden="true"><i style="width:{{ min(100, round($fields->count() / $limit * 100)) }}%"></i></span><span class="num"><b>{{ $fields->count() }}</b> / {{ $limit }} · ücretsiz planda</span></div>
    @else
      <div class="limit"><span class="lbl">Alan limiti</span><span class="num"><b>{{ $fields->count() }}</b> alan · Pro planda sınırsız</span></div>
    @endif
  </div>
</main>
