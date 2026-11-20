<ul id="form-results" class="drawer" data-sc-stagger="90" data-sc-in>
    <li class="paper card" data-status="published" @if (! in_array('published', $visible, true)) hidden @endif style="--tilt:-.6deg">
      <span class="serial">No 0003</span>
      <p class="lbl muted">Güncellendi · 2 saat önce</p>
      <h3><a href="{{ route('formcraft.preview.builder') }}">Aralık Buluşmasına kayıt</a></h3>
      <span class="stamp" data-stamp>Yayında</span>
      <dl><dt>Yanıt</dt><dt>Alan</dt><dd class="num">128</dd><dd class="num">6</dd></dl>
      <div class="foot"><code>/f/aralik-bulusmasi</code><button class="btn btn--sm btn--pen" data-copy="{{ route('formcraft.preview.public-form') }}">Linki kopyala</button></div>
    </li>
    <li class="paper card" data-status="draft" @if (! in_array('draft', $visible, true)) hidden @endif style="--tilt:.5deg">
      <span class="serial">No 0002</span>
      <p class="lbl muted">Güncellendi · dün</p>
      <h3><a href="{{ route('formcraft.preview.fields') }}">Stajyer başvurusu</a></h3>
      <span class="stamp stamp--draft" data-stamp style="--r:4deg">Taslak</span>
      <dl><dt>Yanıt</dt><dt>Alan</dt><dd class="num">0</dd><dd class="num">9</dd></dl>
      <div class="foot"><span class="muted">Yayınlanınca link açılır</span><a class="btn btn--sm btn--ghost" href="{{ route('formcraft.preview.form-edit') }}">Ayarlar</a></div>
    </li>
    <li class="paper card" data-status="closed" @if (! in_array('closed', $visible, true)) hidden @endif style="--tilt:-.3deg">
      <span class="serial">No 0001</span>
      <p class="lbl muted">Kapandı · 3 Eylül</p>
      <h3><a href="{{ route('formcraft.preview.submissions') }}">Yaz okulu memnuniyet anketi</a></h3>
      <span class="stamp stamp--closed" data-stamp style="--r:-3deg">Kapalı</span>
      <dl><dt>Yanıt</dt><dt>Alan</dt><dd class="num">84</dd><dd class="num">7</dd></dl>
      <div class="foot"><span class="muted">Yeni yanıt kabul etmiyor</span><a class="btn btn--sm btn--ghost" href="{{ route('formcraft.preview.submissions') }}">Yanıtlar</a></div>
    </li>
  </ul>
  <p @if ($visible !== []) hidden @endif role="status">Aramana uyan form bulunamadı.</p>
  <p class="lbl" style="margin-top:3rem;color:var(--sc-ink-soft)">Örnek veri</p>
