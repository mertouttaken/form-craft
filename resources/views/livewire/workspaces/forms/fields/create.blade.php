<main class="wrap">
  <p class="crumbs"><a href="{{ route('formcraft.preview.forms') }}">Formlar</a> / <a href="{{ route('formcraft.preview.fields') }}">Aralık Buluşmasına kayıt</a> / <span>Yeni alan</span></p>
  <form class="paper sheet" data-prototype-link action="{{ route('formcraft.preview.fields') }}">
    <span class="serial">Alan No 07</span>
    <h1 class="d-lg" style="margin-bottom:2rem">Yeni alan</h1>

    <section class="step" data-sc-in>
      <h2><b>01</b>Alan tipi</h2>
      <div class="types">
        <label><input type="radio" name="type" checked><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16M4 12h10"/></svg><b>Metin</b><small>Tek satır</small></label>
        <label><input type="radio" name="type"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6h16M4 10h16M4 14h16M4 18h9"/></svg><b>Uzun metin</b><small>Çok satır</small></label>
        <label><input type="radio" name="type"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14"/><path d="m3 7 9 6 9-6"/></svg><b>E-posta</b><small>Biçim denetlenir</small></label>
        <label><input type="radio" name="type"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4 7 20M17 4l-2 16M4 9h17M3 15h17"/></svg><b>Sayı</b><small>Min ve max</small></label>
        <label><input type="radio" name="type"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="6" width="18" height="12"/><path d="m14 11 2.5 2.5L19 11"/></svg><b>Seçim</b><small>Açılır liste</small></label>
        <label><input type="radio" name="type"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="7" cy="8" r="3"/><circle cx="7" cy="16" r="3"/><circle cx="7" cy="8" r="1" fill="currentColor"/><path d="M13 8h8M13 16h8"/></svg><b>Tek seçim</b><small>Radyo düğmesi</small></label>
        <label><input type="radio" name="type"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="5" width="6" height="6"/><rect x="4" y="13" width="6" height="6"/><path d="m5.5 8 1.5 1.5L9 7M13 8h8M13 16h8"/></svg><b>Çoklu seçim</b><small>Onay kutuları</small></label>
        <label><input type="radio" name="type"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16"/><path d="M3 10h18M8 3v4M16 3v4"/></svg><b>Tarih</b><small>Gün, ay, yıl</small></label>
      </div>
    </section>

    <section class="step" data-sc-in>
      <h2><b>02</b>Soru</h2>
      <div class="grid2">
        <div class="field field--error" style="grid-column:1/-1"><label class="lbl" for="l">Etiket</label><input class="input" id="l"><p class="field__error">Etiket zorunlu. Yanıtlayan hata mesajlarında bu adı görecek.</p></div>
        <div class="field"><label class="lbl" for="p">Yer tutucu</label><input class="input" id="p" placeholder="Örn. Deniz Yılmaz"></div>
        <div class="field"><label class="lbl" for="h">Yardım metni</label><input class="input" id="h" placeholder="Alanın altında küçük yazı"></div>
        <label class="check" style="grid-column:1/-1"><input type="checkbox" checked> Zorunlu alan</label>
      </div>
    </section>

    <section class="step" data-sc-in>
      <h2><b>03</b>Seçenekler <span class="lbl muted" style="font-size:.7rem">· seçim, tek seçim ve çoklu seçim için</span></h2>
      <div class="opts">
        <div class="opt"><span class="field__no">A</span><input class="input" value="Sabah" aria-label="Seçenek A"><button type="button" class="x" aria-label="Seçeneği sil">×</button></div>
        <div class="opt"><span class="field__no">B</span><input class="input" value="Öğleden sonra" aria-label="Seçenek B"><button type="button" class="x" aria-label="Seçeneği sil">×</button></div>
        <button type="button" class="btn btn--sm btn--ghost" style="justify-self:start;margin-top:.5rem">+ Seçenek ekle</button>
      </div>
    </section>

    <section class="step" data-sc-in>
      <h2><b>04</b>Kurallar <span class="lbl muted" style="font-size:.7rem">· isteğe bağlı</span></h2>
      <div class="rules">
        <div class="field"><label class="lbl" for="mn">En az</label><input class="input" id="mn" inputmode="numeric" placeholder="1"></div>
        <div class="field"><label class="lbl" for="mx">En çok</label><input class="input" id="mx" inputmode="numeric" placeholder="4"></div>
        <div class="field"><label class="lbl" for="rx">Desen (regex)</label><input class="input" id="rx" placeholder="^[0-9]{11}$"></div>
      </div>
      <p class="field__help" style="margin-top:1rem">Sayı alanında değer sınırı, metin alanında karakter sınırı olarak uygulanır.</p>
    </section>

    <div class="submit"><a class="btn btn--ghost" href="{{ route('formcraft.preview.fields') }}">Vazgeç</a><button class="btn btn--stamp" type="submit">Alanı kaydet</button></div>
  </form>
</main>
