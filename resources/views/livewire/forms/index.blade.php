<div>
<span data-sc-progress></span>
<header class="mast"><b>Aralık Buluşmasına kayıt</b><span class="lbl muted">Örnek form · 6 soru</span></header>

<form wire:submit="submit">
  <section class="q intro" data-sc-act="flow">
    <div data-fc-in data-fc-stagger>
      <p class="lbl" style="color:var(--stamp)">Kayıt formu</p>
      <h1 class="d-xl">Aralık Buluşmasına kayıt</h1>
      <p>Aralık Buluşması için kayıt formu. 10 Aralık'a kadar açık.</p>
      <a class="btn btn--pen" href="#q1">Başla</a>
    </div>
  </section>

  <section class="q" id="q1" data-sc-act="flow"><div class="q__in" data-fc-in="view">
    <span class="q__no">01</span>
    <div class="field"><label for="a1">Ad soyad <span class="req" aria-hidden="true">*</span></label><p class="field__help">Yaka kartında bu isim yazacak.</p><input class="input" id="a1" wire:model="name" maxlength="120" required autocomplete="name" placeholder="Deniz Yılmaz">
      @error('name')<p class="field__error">{{ $message }}</p>@enderror
    </div>
  </div></section>

  <section class="q" data-sc-act="flow"><div class="q__in" data-fc-in="view">
    <span class="q__no">02</span>
    <div class="field"><label for="a2">E-posta <span class="req" aria-hidden="true">*</span></label><p class="field__help">Onay ve hatırlatma için.</p><input class="input" id="a2" wire:model="email" maxlength="254" type="email" required autocomplete="email" placeholder="ornek@eposta.com">
      @error('email')<p class="field__error">{{ $message }}</p>@enderror
    </div>
  </div></section>

  <section class="q" data-sc-act="flow"><div class="q__in" data-fc-in="view">
    <span class="q__no">03</span>
    <fieldset><legend>Hangi oturuma katılacaksın? <span class="req" aria-hidden="true">*</span></legend><p class="field__help">Birini seç.</p>
      <div class="choices"><label><input type="radio" wire:model="session" name="session" value="morning" required> Sabah</label><label><input type="radio" wire:model="session" name="session" value="afternoon"> Öğleden sonra</label><label><input type="radio" wire:model="session" name="session" value="both"> İkisi de</label></div>
      @error('session')<p class="field__error">{{ $message }}</p>@enderror
    </fieldset>
  </div></section>

  <section class="q" data-sc-act="flow"><div class="q__in" data-fc-in="view">
    <span class="q__no">04</span>
    <div class="field"><label for="a4">Kaç kişi geleceksin?</label><p class="field__help">1 ile 4 arası.</p><input class="input" id="a4" wire:model="attendees" type="number" min="1" max="4" style="max-width:10rem">
      @error('attendees')<p class="field__error">{{ $message }}</p>@enderror
    </div>
  </div></section>

  <section class="q" data-sc-act="flow"><div class="q__in" data-fc-in="view">
    <span class="q__no">05</span>
    <div class="field"><label for="a5">Geliş tarihi</label><input class="input" id="a5" wire:model="arrivalDate" type="date" style="max-width:16rem;margin-top:1.75rem">
      @error('arrivalDate')<p class="field__error">{{ $message }}</p>@enderror
    </div>
  </div></section>

  <section class="q" data-sc-act="flow"><div class="q__in" data-fc-in="view">
    <span class="q__no">06</span>
    <div class="send">
      <div class="field" style="width:100%"><label for="a6">Notun var mı?</label><p class="field__help">İsteğe bağlı.</p><textarea class="textarea" id="a6" wire:model="note" maxlength="1000"></textarea>
        @error('note')<p class="field__error">{{ $message }}</p>@enderror
      </div>
            
      @if ($errors->any())
        <p class="field__error" role="status">Göndermeden önce işaretlenen alanları kontrol et.</p>
      @endif
      <button class="btn btn--stamp" type="submit" wire:loading.attr="disabled">
        <span wire:loading.remove wire:target="submit">Gönder</span>
        <span wire:loading wire:target="submit">Kontrol ediliyor…</span>
      </button>
      <p class="field__help">Gönderdiğinde örnek onay makbuzu açılır.</p>
    </div>
  </div></section>
</form>
<p class="powered">FormCraft ile hazırlandı</p>
</div>
