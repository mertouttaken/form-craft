<div class="wrap">
    @if (request()->routeIs('dashboard'))
        <p class="lbl dashboard-preview">{{ $workspace?->name ?? 'Çalışma alanın yok' }}</p>
    @endif
    <div class="pagehead">
        <div data-fc-in>
          <h1 class="d-lg">Formlar</h1>
          <p class="lede">Taslakta olanlar, yayında olanlar, kapananlar.</p>
        </div>
        @if ($workspace && ! $limitReached)
          <span data-fc-in><a class="btn btn--stamp" href="{{ route('formcraft.preview.form-create', ['workspace' => $workspace->slug]) }}">+ Yeni form</a></span>
        @else
          <span data-fc-in><button class="btn btn--stamp" type="button" aria-disabled="true" @if ($limitReached) aria-describedby="limit" @endif>+ Yeni form</button></span>
        @endif
    </div>

    @if ($limitReached)
      <p class="notice" id="limit" data-fc-in style="margin-bottom:2.5rem"><b>{{ $counts['all'] }} / {{ $limit }} form.</b> Ücretsiz planda en fazla {{ $limit }} form oluşturabilirsin. Yeni form için bir formu sil ya da Pro plana geç.</p>
    @endif

    <div class="tools">
      <div class="chips" role="group" aria-label="Duruma göre filtrele">
        <button type="button" wire:click="filter('all')" aria-pressed="{{ $status === 'all' ? 'true' : 'false' }}">Tümü · {{ $counts['all'] }}</button>
        <button type="button" wire:click="filter('published')" aria-pressed="{{ $status === 'published' ? 'true' : 'false' }}">Yayında · {{ $counts['published'] }}</button>
        <button type="button" wire:click="filter('draft')" aria-pressed="{{ $status === 'draft' ? 'true' : 'false' }}">Taslak · {{ $counts['draft'] }}</button>
        <button type="button" wire:click="filter('closed')" aria-pressed="{{ $status === 'closed' ? 'true' : 'false' }}">Kapalı · {{ $counts['closed'] }}</button>
      </div>
      <label class="search"><span class="sr" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)">Form ara</span>
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <input type="search" wire:model.live.debounce.300ms="search" maxlength="120" aria-controls="form-results" placeholder="Form adına göre ara"></label>
    </div>

    @include('formcraft.form-list')
</div>
