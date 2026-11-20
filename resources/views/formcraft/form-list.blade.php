<ul id="form-results" class="drawer" data-fc-stagger data-fc-in>
    @forelse ($forms as $form)
      @if($form->status === 'published')
        <li class="paper card" data-status="published" @if (! in_array('published', $visible, true)) hidden @endif style="--tilt:-.6deg">
          <span class="serial">No {{ str_pad($form->id, 4, '0', STR_PAD_LEFT) }}</span>
          <p class="lbl muted">Güncellendi · {{ $form->updated_at->diffForHumans() }}</p>
          <h3><a href="{{ route('formcraft.preview.builder', ['form' => $form]) }}">{{ $form->title }}</a></h3>
          <span class="stamp" data-stamp>Yayında</span>
          <dl><dt>Yanıt</dt><dt>Alan</dt><dd class="num">{{ $form->submissions_count }}</dd><dd class="num">{{ $form->fields_count }}</dd></dl>
          <div class="foot"><code>{{ route('formcraft.preview.public-form', ['form' => $form]) }}</code><button class="btn btn--sm btn--pen" data-copy="{{ route('formcraft.preview.public-form', ['form' => $form]) }}">Linki kopyala</button></div>
        </li>
      @elseif($form->status === 'draft')
        <li class="paper card" data-status="draft" @if (! in_array('draft', $visible, true)) hidden @endif style="--tilt:.5deg">
          <span class="serial">No {{ str_pad($form->id, 4, '0', STR_PAD_LEFT) }}</span>
          <p class="lbl muted">Güncellendi · {{ $form->updated_at->diffForHumans() }}</p>
          <h3><a href="{{ route('formcraft.preview.fields', ['form' => $form]) }}">{{ $form->title }}</a></h3>
          <span class="stamp stamp--draft" data-stamp style="--r:4deg">Taslak</span>
          <dl><dt>Yanıt</dt><dt>Alan</dt><dd class="num">{{ $form->submissions_count }}</dd><dd class="num">{{ $form->fields_count }}</dd></dl>
          <div class="foot"><span class="muted">Yayınlanınca link açılır</span><a class="btn btn--sm btn--ghost" href="{{ route('formcraft.preview.form-edit', ['form' => $form]) }}">Ayarlar</a></div>
        </li>
      @elseif($form->status === 'closed') 
        <li class="paper card" data-status="closed" @if (! in_array('closed', $visible, true)) hidden @endif style="--tilt:-.3deg">
          <span class="serial">No {{ str_pad($form->id, 4, '0', STR_PAD_LEFT) }}</span>
          <p class="lbl muted">Kapandı · {{ $form->updated_at->diffForHumans() }}</p>
          <h3><a href="{{ route('formcraft.preview.submissions', ['form' => $form]) }}">{{ $form->title }}</a></h3>
          <span class="stamp stamp--closed" data-stamp style="--r:-3deg">Kapalı</span>
          <dl><dt>Yanıt</dt><dt>Alan</dt><dd class="num">{{ $form->submissions_count }}</dd><dd class="num">{{ $form->fields_count }}</dd></dl>
          <div class="foot"><span class="muted">Yeni yanıt kabul etmiyor</span><a class="btn btn--sm btn--ghost" href="{{ route('formcraft.preview.submissions', ['form' => $form]) }}">Yanıtlar</a></div>
        </li>
      @endif
    @empty
      <li class="paper card" data-status="empty" style="--tilt:0deg">
        <span class="serial">No 0000</span>
        <p class="lbl muted">Henüz form yok</p>
        <h3><a href="{{ route('formcraft.preview.form-create') }}">Yeni form oluştur</a></h3>
        <span class="stamp" data-stamp>Boş</span>
        <dl><dt>Yanıt</dt><dt>Alan</dt><dd class="num">0</dd><dd class="num">0</dd></dl>    
    @endforelse
  </ul>
  <p @if ($visible !== []) hidden @endif role="status">Aramana uyan form bulunamadı.</p>
