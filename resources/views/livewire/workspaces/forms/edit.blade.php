<main class="wrap">
  <p class="crumbs"><a href="{{ route('formcraft.preview.forms') }}">Formlar</a> / <span>Aralık Buluşmasına kayıt</span></p>
  <div class="pagehead"><h1 class="d-lg">Aralık Buluşmasına kayıt</h1></div>
  <nav class="tabs" aria-label="Form"><a href="{{ route('formcraft.preview.form-edit') }}" aria-current="page">Ayarlar</a><a href="{{ route('formcraft.preview.fields') }}">Alanlar · 6</a><a href="{{ route('formcraft.preview.submissions') }}">Yanıtlar · 128</a></nav>

  <div class="layout">
    <nav class="folio" aria-label="Bölümler">
      <a href="#genel"><b>01</b> Genel</a><a href="#durum"><b>02</b> Durum</a><a href="#sonra"><b>03</b> Gönderimden sonra</a><a href="#bildirim"><b>04</b> Bildirim</a><a href="#sil"><b>05</b> Formu sil</a>
    </nav>

    <form class="paper sheet">
      <section class="chap" id="genel" data-sc-in>
        <div><h2>01 · Genel</h2><p class="field__help">Yanıtlayanın göreceği başlık ve açıklama.</p></div>
        <div class="stack">
          <div class="field"><label class="lbl" for="t">Başlık</label><input class="input" id="t" value="Aralık Buluşmasına kayıt"></div>
          <div class="field"><label class="lbl" for="d">Açıklama</label><textarea class="textarea" id="d">Aralık Buluşması için kayıt formu. 10 Aralık'a kadar açık.</textarea></div>
        </div>
      </section>

      <section class="chap" id="durum" data-sc-in>
        <div><h2>02 · Durum</h2><p class="field__help">Yalnızca yayındaki form herkese açık linkte görünür. Taslak ve kapalı formlarda link 404 döner.</p></div>
        <div>
          <fieldset class="status" style="border:0;padding:0;margin:0">
            <legend class="sr" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)">Durum</legend>
            <label><input type="radio" name="s" data-restamp="#st" data-text="Taslak" data-class="stamp--draft"><b>Taslak</b><small>Sadece ekip görür</small></label>
            <label><input type="radio" name="s" checked data-restamp="#st" data-text="Yayında" data-class=""><b>Yayında</b><small>Link açık, yanıt alır</small></label>
            <label><input type="radio" name="s" data-restamp="#st" data-text="Kapalı" data-class="stamp--closed"><b>Kapalı</b><small>Link açık değil</small></label>
          </fieldset>
          <div class="preview"><span class="stamp" id="st" data-stamp style="font-size:1.4rem">Yayında</span><span class="muted">/f/<span class="pen">aralik-bulusmasi</span></span></div>
        </div>
      </section>

      <section class="chap" id="sonra" data-sc-in>
        <div><h2>03 · Gönderimden sonra</h2><p class="field__help">Yanıtlayan formu gönderince ne görsün?</p></div>
        <div class="stack">
          <div class="field"><label class="lbl" for="m">Başarı mesajı</label><input class="input" id="m" value="Kaydın alındı, görüşmek üzere."></div>
          <div class="field"><label class="lbl" for="r">Yönlendirme adresi <span class="muted">· isteğe bağlı</span></label><input class="input" id="r" type="url" placeholder="https://"><p class="field__help">Doluysa teşekkür sayfası yerine bu adrese gider.</p></div>
          <label class="check"><input type="checkbox"> Aynı kişi birden fazla kez gönderebilsin</label>
        </div>
      </section>

      <section class="chap" id="bildirim" data-sc-in>
        <div><h2>04 · Bildirim</h2><p class="field__help">Her yeni yanıtta bu adrese e-posta gider.</p></div>
        <div class="field"><label class="lbl" for="n">Bildirim e-postası</label><input class="input" id="n" type="email" value="deniz@ornek.com"></div>
      </section>

      <section class="chap" id="sil" data-sc-in>
        <div><h2>05 · Formu sil</h2><p class="field__help">Yalnızca sahip ve editör silebilir.</p></div>
        <div class="danger"><span>Form, 6 alanı ve 128 yanıtı kalıcı olarak silinir.</span><button type="button" class="btn btn--stamp btn--sm">Formu sil</button></div>
      </section>

      <div class="savebar"><a class="btn btn--ghost" href="{{ route('formcraft.preview.forms') }}">Vazgeç</a><button class="btn btn--pen" type="button">Kaydet</button></div>
    </form>
  </div>
</main>
