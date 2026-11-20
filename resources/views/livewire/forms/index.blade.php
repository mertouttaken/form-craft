<div>
<span data-sc-progress></span>
<header class="mast"><b>Aralık Buluşmasına kayıt</b><span class="lbl muted">Örnek form · 6 soru</span></header>

<form action="{{ route('formcraft.preview.thanks') }}" data-prototype-link>
  <section class="q intro" data-sc-act="flow">
    <div data-sc-in data-sc-stagger="90">
      <p class="lbl" style="color:var(--stamp)">Kayıt formu</p>
      <h1 class="d-xl">Aralık Buluşmasına kayıt</h1>
      <p>Aralık Buluşması için kayıt formu. 10 Aralık'a kadar açık.</p>
      <a class="btn btn--pen" href="#q1">Başla</a>
    </div>
  </section>

  <section class="q" id="q1" data-sc-act="flow"><div class="q__in" data-sc-in>
    <span class="q__no">01</span>
    <div class="field"><label for="a1">Ad soyad <span class="req" aria-hidden="true">*</span></label><p class="field__help">Yaka kartında bu isim yazacak.</p><input class="input" id="a1" name="answers[1]" required autocomplete="name" placeholder="Deniz Yılmaz"></div>
  </div></section>

  <section class="q" data-sc-act="flow"><div class="q__in" data-sc-in>
    <span class="q__no">02</span>
    <div class="field"><label for="a2">E-posta <span class="req" aria-hidden="true">*</span></label><p class="field__help">Onay ve hatırlatma için.</p><input class="input" id="a2" name="answers[2]" type="email" required autocomplete="email" placeholder="ornek@eposta.com"></div>
  </div></section>

  <section class="q" data-sc-act="flow"><div class="q__in" data-sc-in>
    <span class="q__no">03</span>
    <fieldset><legend>Hangi oturuma katılacaksın? <span class="req" aria-hidden="true">*</span></legend><p class="field__help">Birini seç.</p>
      <div class="choices"><label><input type="radio" name="answers[3]" required> Sabah</label><label><input type="radio" name="answers[3]"> Öğleden sonra</label><label><input type="radio" name="answers[3]"> İkisi de</label></div></fieldset>
  </div></section>

  <section class="q" data-sc-act="flow"><div class="q__in" data-sc-in>
    <span class="q__no">04</span>
    <div class="field"><label for="a4">Kaç kişi geleceksin?</label><p class="field__help">1 ile 4 arası.</p><input class="input" id="a4" name="answers[4]" type="number" min="1" max="4" value="2" style="max-width:10rem"></div>
  </div></section>

  <section class="q" data-sc-act="flow"><div class="q__in" data-sc-in>
    <span class="q__no">05</span>
    <div class="field"><label for="a5">Geliş tarihi</label><input class="input" id="a5" name="answers[5]" type="date" value="2026-12-10" style="max-width:16rem;margin-top:1.75rem"></div>
  </div></section>

  <section class="q" data-sc-act="flow"><div class="q__in" data-sc-in>
    <span class="q__no">06</span>
    <div class="send">
      <div class="field" style="width:100%"><label for="a6">Notun var mı?</label><p class="field__help">İsteğe bağlı.</p><textarea class="textarea" id="a6" name="answers[6]"></textarea></div>
      <div class="hp" aria-hidden="true"><label>Web sitesi <input name="website" tabindex="-1" autocomplete="off"></label></div>
      <button class="btn btn--stamp" type="submit">Gönder</button>
      <p class="field__help">Gönderdiğinde örnek onay makbuzu açılır.</p>
    </div>
  </div></section>
</form>
<p class="powered">FormCraft ile hazırlandı</p>
</div>
