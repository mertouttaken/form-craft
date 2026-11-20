<main class="wrap">
  <p class="crumbs"><a href="{{ route('formcraft.preview.forms') }}">Formlar</a> / <span>Aralık Buluşmasına kayıt</span></p>
  <div class="pagehead">
    <h1 class="d-lg">Aralık Buluşmasına kayıt</h1>
    <a class="btn btn--stamp" href="#" download>
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 4v11M7 10l5 5 5-5M5 20h14"/></svg>CSV indir</a>
  </div>
  <nav class="tabs" aria-label="Form"><a href="{{ route('formcraft.preview.form-edit') }}">Ayarlar</a><a href="{{ route('formcraft.preview.fields') }}">Alanlar · 6</a><a href="{{ route('formcraft.preview.submissions') }}" aria-current="page">Yanıtlar · {{ $demoSubmission ? 129 : 128 }}</a></nav>

  <div class="paper paper--pink" data-fc-in>
    <div class="bar">
      <label class="search"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg><input type="search" placeholder="Yanıtlarda ara" aria-label="Yanıtlarda ara"></label>
      <div class="range"><span class="lbl">Tarih</span><input type="date" aria-label="Başlangıç" value="2026-09-01"><span>·</span><input type="date" aria-label="Bitiş" value="2026-09-30"></div>
      <span class="count lbl"><b class="num">{{ $demoSubmission ? 129 : 128 }}</b> yanıt · sayfa 1 / 6</span>
    </div>
    <div class="scroller">
      <table class="table">
        <thead><tr><th>No</th><th>Gönderim</th><th>Ad soyad</th><th>E-posta</th><th>Oturum</th><th>Kişi</th><th>Geliş</th></tr></thead>
        <tbody data-fc-stagger data-fc-in>
          @if ($demoSubmission)
            <tr data-demo-submission>
              <td><a href="{{ route('formcraft.preview.thanks') }}">Makbuz ↗</a></td>
              <td class="num">{{ $demoSubmission['submittedAt'] }}</td>
              <td>{{ $demoSubmission['name'] }}</td>
              <td>{{ $demoSubmission['email'] }}</td>
              <td><strong>{{ $demoSubmission['session'] }}</strong></td>
              <td class="num">{{ $demoSubmission['attendees'] ?? '·' }}</td>
              <td class="num">{{ $demoSubmission['arrivalDate'] ?? '·' }}</td>
            </tr>
          @endif
          <tr data-open="#dlg"><td class="num">128</td><td class="num">29.11 · 18:41</td><td>Selin Arslan</td><td>selin@ornek.com</td><td>İkisi de</td><td class="num">2</td><td class="num">10.12.2026</td></tr>
          <tr data-open="#dlg"><td class="num">127</td><td class="num">29.11 · 11:02</td><td>Burak Demir</td><td>burak@ornek.com</td><td>Sabah</td><td class="num">1</td><td class="num">10.12.2026</td></tr>
          <tr data-open="#dlg"><td class="num">126</td><td class="num">28.11 · 22:15</td><td>Zeynep Çelik</td><td>zeynep@ornek.com</td><td>Öğleden sonra</td><td class="num">3</td><td class="muted">·</td></tr>
          <tr data-open="#dlg"><td class="num">125</td><td class="num">28.11 · 09:40</td><td>Mert Aydın</td><td>mert@ornek.com</td><td>Sabah</td><td class="muted">·</td><td class="num">11.10.2026</td></tr>
          <tr data-open="#dlg"><td class="num">124</td><td class="num">27.11 · 16:28</td><td>Ece Kaya</td><td>ece@ornek.com</td><td>Öğleden sonra</td><td class="num">1</td><td class="num">10.12.2026</td></tr>
          <tr data-open="#dlg"><td class="num">123</td><td class="num">27.11 · 14:03</td><td>Deniz Yılmaz</td><td>deniz@ornek.com</td><td>İkisi de</td><td class="num">4</td><td class="num">10.12.2026</td></tr>
          <tr data-open="#dlg"><td class="num">122</td><td class="num">26.11 · 20:55</td><td>Kaan Öztürk</td><td>kaan@ornek.com</td><td>Sabah</td><td class="num">2</td><td class="num">12.12.2026</td></tr>
          <tr data-open="#dlg"><td class="num">121</td><td class="num">26.11 · 08:12</td><td>Elif Şahin</td><td>elif@ornek.com</td><td>Sabah</td><td class="num">1</td><td class="muted">·</td></tr>
        </tbody>
      </table>
    </div>
    <div class="pager"><span>1–25 / {{ $demoSubmission ? 129 : 128 }}</span><nav aria-label="Sayfalar"><a href="#" aria-current="page">1</a><a href="#">2</a><a href="#">3</a><a href="#">…</a><a href="#">6</a></nav></div>
  </div>
  <p class="lbl" style="margin-top:1.25rem;color:var(--sc-ink-soft)">Kolonlar formun alanlarından üretilir. Boş yanıt "·" ile gösterilir. Son örnek gönderim bu tarayıcı oturumuna aittir.</p>

  <dialog id="dlg" class="paper paper--pink" aria-labelledby="dt">
    <div class="detail">
      <span class="serial">Yanıt No 128</span>
      <h2 class="d-md" id="dt">Selin Arslan</h2>
      <span class="stamp" style="font-size:.85rem;margin-top:1rem">Alındı</span>
      <dl>
        <div><dt>01 · Ad soyad</dt><dd class="pen">Selin Arslan</dd></div>
        <div><dt>02 · E-posta</dt><dd class="pen">selin@ornek.com</dd></div>
        <div><dt>03 · Hangi oturuma katılacaksın?</dt><dd class="pen">İkisi de</dd></div>
        <div><dt>04 · Kaç kişi geleceksin?</dt><dd class="pen">2</dd></div>
        <div><dt>05 · Geliş tarihi</dt><dd class="pen">10.12.2026</dd></div>
        <div><dt>06 · Notun var mı?</dt><dd class="pen">Vejetaryen menü olursa sevinirim.</dd></div>
      </dl>
      <div class="perf" style="margin:1.5rem -2rem 0"></div>
      <div class="meta"><span>29.11.2026 · 18:41</span><form method="dialog"><button class="btn btn--sm btn--ghost">Kapat</button></form></div>
    </div>
  </dialog>
</main>
