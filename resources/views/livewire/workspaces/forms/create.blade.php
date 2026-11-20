<main class="wrap">
  <p class="crumbs"><a href="{{ route('formcraft.preview.forms') }}">Formlar</a> / <span>Yeni form</span></p>
  <form class="paper sheet" wire:submit="save" novalidate>
    <span class="serial">Yeni form · taslak olarak açılır</span>
    <h1 class="d-lg" style="margin-bottom:2.5rem">Yeni form</h1>

    <div class="q" data-fc-in>
      <span class="q__no">01</span>
      <div @class(['field', 'field--error' => $errors->has('title')])><h2><label for="t">Formun adı ne?</label></h2><p class="field__help">Yanıtlayanlar bu başlığı görecek.</p><input class="input" id="t" placeholder="Etkinlik kaydı" wire:model.live.debounce.250ms="title" autocomplete="off" maxlength="120" required autofocus @error('title') aria-invalid="true" aria-describedby="t-error" @enderror>
        @error('title')<p class="field__error" id="t-error">{{ $message }}</p>@enderror</div>
    </div>
    <div class="q" data-fc-in>
      <span class="q__no">02</span>
      <div @class(['field', 'field--error' => $errors->has('description')])><h2><label for="d">Kısa bir açıklama</label> <span class="lbl muted">isteğe bağlı</span></h2><p class="field__help">Başlığın altında görünür. Ne için, kimden, ne zamana kadar.</p><textarea class="textarea" id="d" wire:model="description" placeholder="Aralık Buluşması için kayıt formu. 10 Aralık'a kadar açık." maxlength="500"></textarea>
        @error('description')<p class="field__error">{{ $message }}</p>@enderror</div>
    </div>
    <div class="q" data-fc-in>
      <span class="q__no">03</span>
      <div class="field"><h2>Link adresi</h2><p class="field__help">Başlıktan otomatik üretilir. Yayınlayana kadar kimse açamaz.</p>
        <p style="margin:.5rem 0 0;font-size:1.15rem" aria-live="polite">/f/@if ($this->slug !== '')<span class="pen">{{ $this->slug }}</span>@else<span class="muted">etkinlik_kaydi</span>@endif</p></div>
    </div>
    <div class="submit">
      <span class="stamp stamp--draft" data-stamp style="font-size:.9rem">Taslak</span>
      <div style="display:flex;gap:.75rem">
        <a class="btn btn--ghost" href="{{ route('formcraft.preview.forms') }}">Vazgeç</a>
        <button class="btn btn--stamp" type="submit" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save">Oluştur ve alan ekle</span><span wire:loading wire:target="save">Oluşturuluyor…</span></button>
      </div>
    </div>
    <div class="perf" style="margin:0 -4rem"></div>
  </form>
</main>
