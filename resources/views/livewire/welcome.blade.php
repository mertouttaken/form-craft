<div>
<header class="press-header">
  <a class="brand" href="#bas"><b>FormCraft<span>.</span></b></a>
  <nav aria-label="Ana menü">
    <a class="press-nav-link" href="#onizle">Demoyu keşfet</a>
    @auth
        <a class="press-button" href="{{ route('dashboard') }}">Çalışma alanım ↗</a>
    @else
        <a class="press-nav-link" href="{{ route('login') }}">Giriş yap</a>
        <a class="press-button" href="{{ route('register') }}">Ücretsiz başla ↗</a>
    @endauth
  </nav>
</header>
<main>
  <section class="press-scene" aria-labelledby="press-heading">
    <div class="press-window">
      <div class="press-grid" aria-hidden="true"></div>
      <div class="press-copy">
        <h1 id="press-heading">Sorunu yaz.<br><em>Yanıtı gelsin.</em></h1>
        <p>Ekibinle form hazırla, bağlantıyı paylaş. Gelen yanıtları aynı çalışma alanında gör.</p>
        <a class="press-button press-button--line" href="{{ route('formcraft.preview.builder') }}">Form kurucuyu dene <span aria-hidden="true">↗</span></a>
      </div>
      <div class="press-samples">
        <div class="press-stock stock-answer" aria-hidden="true">
          <div class="stock-head"><span>03 / YANIT</span><span>FORMCRAFT</span></div>
          <h2>Kayıt defteri</h2>
          <div class="stock-record"><b>Ad soyad</b><small>Oturum</small></div>
          <div class="stock-record"><span>Deniz Yılmaz</span><small>Sabah</small></div>
          <div class="stock-record"><span>Ece Kaya</span><small>Öğleden sonra</small></div>
          <div class="stock-record"><span>Selin Arslan</span><small>İkisi de</small></div>
          <span class="stock-foot">YANITLAYAN NÜSHASI</span>
        </div>
        <div class="press-stock stock-public">
          <div class="stock-head" aria-hidden="true"><span>02 / PAYLAŞIM</span><span>FORMCRAFT</span></div>
          <h2 aria-hidden="true">Aralık Buluşması</h2>
          <p aria-hidden="true">Katılımcı kayıt formu</p>
          <div class="stock-print" aria-hidden="true">
            <div class="stock-stamp">YAYINDA</div>
            <div class="stamp-tool"><span></span></div>
          </div>
          <a class="stock-link" href="{{ route('formcraft.preview.public-form') }}" aria-label="Aralık Buluşması formunu aç" inert>
            /f/aralik-bulusmasi <span aria-hidden="true">↗</span>
          </a>
          <span class="stock-foot" aria-hidden="true">HERKESE AÇIK NÜSHA</span>
        </div>
        <div class="press-stock stock-edit" aria-hidden="true">
          <div class="stock-head"><span>01 / ASIL NÜSHA</span><span>FC–0147</span></div>
          <p class="stock-type">ETKİNLİK KAYDI</p>
          <h2>Aralık<br>buluşmasına<br>kayıt.</h2>
          <div class="stock-field"><b>01</b><div>Ad soyad<span class="pen">Deniz Yılmaz</span></div></div>
          <div class="stock-field"><b>02</b><div>E-posta<span class="pen">deniz@ornek.com</span></div></div>
          <div class="stock-field"><b>03</b><div>Oturum<span class="pen">Sabah</span></div></div>
          <span class="stock-foot">ÇALIŞMA ALANI NÜSHASI</span>
        </div>
      </div>
      <div class="press-track">
        <span class="press-step">Formu hazırla</span>
        <div aria-hidden="true" class="press-progress"><span></span></div>
        <a href="#onizle">Prototipi incele ↓</a>
      </div>
    </div>
  </section>
  <section class="press-demo" id="onizle" aria-labelledby="demo-heading">
    <div class="press-demo-inner">
      <h2 id="demo-heading">Aynı form,<br><em>üç farklı nüsha.</em></h2>
      <div class="press-index">
        <a href="{{ route('formcraft.preview.builder') }}"><small>01 / ASIL NÜSHA</small><b>Formu kur.</b><span>Alan ekle, sırala ve yazdıkça önizle.</span><i aria-hidden="true">↗</i></a>
        <a href="{{ route('formcraft.preview.public-form') }}"><small>02 / PAYLAŞIM</small><b>Linki aç.</b><span>Katılımcının gördüğü kayıt formunu dene.</span><i aria-hidden="true">↗</i></a>
        <a href="{{ route('formcraft.preview.submissions') }}"><small>03 / YANIT</small><b>Yanıtları gör.</b><span>Gönderimleri çalışma alanında incele.</span><i aria-hidden="true">↗</i></a>
      </div>
    </div>
  </section>
</main>
<footer class="press-footer"><a class="brand" href="#bas"><b>FormCraft.</b></a><a href="{{ route('formcraft.preview.forms') }}">Örnek çalışma alanı ↗</a></footer>
</div>
