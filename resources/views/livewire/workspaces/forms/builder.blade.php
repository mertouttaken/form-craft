<main class="wrap builder-wrap">
  <p class="crumbs"><a href="{{ route('formcraft.preview.forms') }}">Formlar</a> / <span>Form kurucu</span></p>
  <div class="builder-heading">
    <div><h1 class="d-lg">Aralık Buluşması</h1><p>Alanlarını düzenle, sarı nüshada formu canlı gör.</p></div>
    <div class="builder-actions">
      <a class="btn btn--ghost" href="{{ route('formcraft.preview.fields') }}">Klasik alan listesi</a>
      <a class="btn btn--stamp" href="{{ route('formcraft.preview.public-form') }}">Örnek formu aç ↗</a>
    </div>
  </div>
  <div class="builder-grid">
    <aside class="builder-palette" aria-labelledby="palette-title">
      <h2 id="palette-title">Alan ekle</h2>
      <p class="builder-count" role="status"><span id="builder-count">{{ count($order) }} / {{ $limit }} alan</span></p>
      <div class="builder-types" id="builder-types">
        @foreach ($types as $type => [$title, $symbol])
          <button type="button" data-type="{{ $type }}" wire:click="addField('{{ $type }}')" wire:loading.attr="disabled" @disabled(count($order) >= $limit)>
            <small aria-hidden="true">{{ $symbol }}</small> {{ $title }} <b aria-hidden="true">+</b>
          </button>
        @endforeach
      </div>
      @if (count($order) >= $limit)
        <p id="builder-limit">Ücretsiz planın {{ $limit }} alan sınırına ulaştın.</p>
      @endif
    </aside>
    <section class="builder-sheet paper" aria-labelledby="editor-title">
      <h2 id="editor-title">Form alanları</h2>
      <ol id="builder-list">
        @foreach ($order as $id)
          @php($type = $fieldTypes[$id])
          <li class="builder-line" wire:key="editor-{{ $id }}">
            <div class="editor-top">
              <span class="editor-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
              <span class="editor-type">{{ $types[$type][0] }}</span>
              <div class="editor-buttons">
                <button type="button" wire:click="moveField({{ $id }}, -1)" @disabled($loop->first) aria-label="Yukarı taşı">↑</button>
                <button type="button" wire:click="moveField({{ $id }}, 1)" @disabled($loop->last) aria-label="Aşağı taşı">↓</button>
                <button type="button" wire:click="removeField({{ $id }})" wire:confirm="Bu alanı örnek formdan kaldırmak istiyor musun?" aria-label="Alanı kaldır">×</button>
              </div>
            </div>
            <label>Alan etiketi<input class="input" maxlength="150" wire:model.live.debounce.350ms="settings.{{ $id }}.label"></label>
            @if (in_array($type, $choiceTypes, true))
              <label>Seçenekler <small>Her satıra bir seçenek yaz.</small><textarea class="textarea" rows="3" maxlength="1000" wire:model.live.debounce.350ms="settings.{{ $id }}.options"></textarea></label>
            @elseif ($type !== 'date')
              <label>Yer tutucu<input class="input" maxlength="150" wire:model.live.debounce.350ms="settings.{{ $id }}.placeholder"></label>
            @endif
            <label class="check"><input type="checkbox" wire:model.live="settings.{{ $id }}.required"> Zorunlu alan</label>
          </li>
        @endforeach
      </ol>
      @if ($order === [])
        <p class="builder-empty">Forma ilk alanını ekle.</p>
      @endif
    </section>
    <section class="builder-preview paper paper--canary" aria-labelledby="preview-title">
      <p class="lbl">Canlı önizleme</p>
      <h2 id="preview-title">Aralık Buluşmasına kayıt</h2>
      <p>Aralık Buluşması için kayıt formu.</p>
      <div id="preview-fields">
        @foreach ($order as $id)
          @include('livewire.workspaces.forms.fields.preview-input', ['id' => $id, 'type' => $fieldTypes[$id], 'field' => $settings[$id]])
        @endforeach
      </div>
    </section>
  </div>
  <p class="builder-note" role="status" id="builder-note">{{ $notice }}</p>
</main>
