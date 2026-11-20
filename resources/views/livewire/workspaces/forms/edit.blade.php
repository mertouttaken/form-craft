<main class="wrap">
  <p class="crumbs"><a href="{{ route('formcraft.preview.forms', ['workspace' => $this->workspaceModel->slug]) }}">Formlar</a> / <span>{{ $form->title }}</span></p>
  <div class="pagehead"><h1 class="d-lg">{{ $form->title }}</h1></div>
  <nav class="tabs" aria-label="Form"><a href="{{ route('formcraft.preview.form-edit', $this->formRoute) }}" aria-current="page">Ayarlar</a><a href="{{ route('formcraft.preview.fields', $this->formRoute) }}">Alanlar · {{ $fieldCount }}</a><a href="{{ route('formcraft.preview.submissions', $this->formRoute) }}">Yanıtlar · {{ $submissionCount }}</a></nav>

  <div class="layout">
    <nav class="folio" aria-label="Bölümler">
      <a href="#genel"><b>01</b> Genel</a><a href="#durum"><b>02</b> Durum</a><a href="#sonra"><b>03</b> Gönderimden sonra</a><a href="#bildirim"><b>04</b> Bildirim</a><a href="#sil"><b>05</b> Formu sil</a>
    </nav>

    <form class="paper sheet" wire:submit="save" novalidate>
      <section class="chap" id="genel" data-fc-in>
        <div><h2>01 · Genel</h2><p class="field__help">Yanıtlayanın göreceği başlık ve açıklama.</p></div>
        <div class="stack">
          <div @class(['field', 'field--error' => $errors->has('title')])><label class="lbl" for="t">Başlık</label><input class="input" id="t" wire:model="title" maxlength="120" required>
            @error('title')<p class="field__error">{{ $message }}</p>@enderror</div>
          <div @class(['field', 'field--error' => $errors->has('description')])><label class="lbl" for="d">Açıklama</label><textarea class="textarea" id="d" wire:model="description" maxlength="500"></textarea>
            @error('description')<p class="field__error">{{ $message }}</p>@enderror</div>
        </div>
      </section>

      <section class="chap" id="durum" data-fc-in>
        <div><h2>02 · Durum</h2><p class="field__help">Yalnızca yayındaki form herkese açık linkte görünür. Taslak ve kapalı formlarda link 404 döner.</p></div>
        <div>
          <fieldset class="status" style="border:0;padding:0;margin:0">
            <legend class="sr" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)">Durum</legend>
            @foreach (\App\Livewire\Workspaces\Forms\Edit::STATUSES as $value => [$label, $help])
              <label wire:key="status-{{ $value }}"><input type="radio" name="status" value="{{ $value }}" wire:model.live="status"><b>{{ $label }}</b><small>{{ $help }}</small></label>
            @endforeach
          </fieldset>
          @php
            [$stampLabel, , $stampClass] = \App\Livewire\Workspaces\Forms\Edit::STATUSES[$status] ?? \App\Livewire\Workspaces\Forms\Edit::STATUSES['draft'];
          @endphp
          <div class="preview"><span @class(['stamp', $stampClass]) data-stamp style="font-size:1.4rem">{{ $stampLabel }}</span><span class="muted">/f/<span class="pen">{{ $form->public_slug }}</span></span></div>
        </div>
      </section>

      <section class="chap" id="sonra" data-fc-in>
        <div><h2>03 · Gönderimden sonra</h2><p class="field__help">Yanıtlayan formu gönderince ne görsün?</p></div>
        <div class="stack">
          <div @class(['field', 'field--error' => $errors->has('successMessage')])><label class="lbl" for="m">Başarı mesajı</label><input class="input" id="m" wire:model="successMessage" maxlength="200" placeholder="Teşekkürler, yanıtın alındı.">
            @error('successMessage')<p class="field__error">{{ $message }}</p>@enderror</div>
          <div @class(['field', 'field--error' => $errors->has('redirectUrl')])><label class="lbl" for="r">Yönlendirme adresi <span class="muted">· isteğe bağlı</span></label><input class="input" id="r" type="url" wire:model="redirectUrl" placeholder="https://"><p class="field__help">Doluysa teşekkür sayfası yerine bu adrese gider.</p>
            @error('redirectUrl')<p class="field__error">{{ $message }}</p>@enderror</div>
          <label class="check"><input type="checkbox" wire:model="allowMultiple"> Aynı kişi birden fazla kez gönderebilsin</label>
        </div>
      </section>

      <section class="chap" id="bildirim" data-fc-in>
        <div><h2>04 · Bildirim</h2><p class="field__help">Her yeni yanıtta bu adrese e-posta gider.</p></div>
        <div @class(['field', 'field--error' => $errors->has('notifyEmail')])><label class="lbl" for="n">Bildirim e-postası</label><input class="input" id="n" type="email" wire:model="notifyEmail" placeholder="ad@ornek.com">
          @error('notifyEmail')<p class="field__error">{{ $message }}</p>@enderror</div>
      </section>

      <section class="chap" id="sil" data-fc-in>
        <div><h2>05 · Formu sil</h2><p class="field__help">Yalnızca sahip ve editör silebilir.</p></div>
        <div class="danger"><span>Form, {{ $fieldCount }} alanı ve {{ $submissionCount }} yanıtı kalıcı olarak silinir.</span><button type="button" class="btn btn--stamp btn--sm" wire:click="delete" wire:confirm="Form, {{ $fieldCount }} alanı ve {{ $submissionCount }} yanıtı kalıcı olarak silinsin mi? Bu geri alınamaz.">Formu sil</button></div>
      </section>

      <div class="savebar">
        @if ($saved)<span class="lbl" role="status" style="margin-right:auto;color:var(--pen)">Kaydedildi</span>@endif
        <a class="btn btn--ghost" href="{{ route('formcraft.preview.forms', ['workspace' => $this->workspaceModel->slug]) }}">Vazgeç</a>
        <button class="btn btn--pen" type="submit" wire:loading.attr="disabled" wire:target="save">Kaydet</button>
      </div>
    </form>
  </div>
</main>
