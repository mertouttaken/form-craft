@php
  // status => [stamp label, stamp class, stamp tilt, card tilt, "updated" label]
  $cardMeta = [
      'published' => ['Yayında', '', '0deg', '-.6deg', 'Güncellendi'],
      'draft' => ['Taslak', 'stamp--draft', '4deg', '.5deg', 'Güncellendi'],
      'closed' => ['Kapalı', 'stamp--closed', '-3deg', '-.3deg', 'Kapandı'],
  ];
@endphp
<ul id="form-results" class="drawer" data-fc-stagger data-fc-in>
  @forelse ($forms as $form)
    @php
      [$stampLabel, $stampClass, $stampTilt, $cardTilt, $updatedLabel] = $cardMeta[$form->status] ?? $cardMeta['draft'];
      $formRoute = ['workspace' => $workspace->slug, 'form' => $form->public_slug];
      $publicUrl = route('formcraft.preview.public-form', ['public_slug' => $form->public_slug]);
    @endphp
    <li class="paper card" wire:key="form-{{ $form->id }}" data-status="{{ $form->status }}" style="--tilt:{{ $cardTilt }}">
      <span class="serial">No {{ str_pad($form->id, 4, '0', STR_PAD_LEFT) }}</span>
      <p class="lbl muted">{{ $updatedLabel }} · {{ $form->updated_at?->diffForHumans() }}</p>
      <h3><a href="{{ route($form->status === 'closed' ? 'formcraft.preview.submissions' : 'formcraft.preview.fields', $formRoute) }}">{{ $form->title }}</a></h3>
      <span @class(['stamp', $stampClass]) data-stamp style="--r:{{ $stampTilt }}">{{ $stampLabel }}</span>
      <dl><dt>Yanıt</dt><dt>Alan</dt><dd class="num">{{ $form->submissions_count }}</dd><dd class="num">{{ $form->fields_count }}</dd></dl>
      <div class="foot">
        @if ($form->status === 'published')
          <code>{{ $publicUrl }}</code><button type="button" class="btn btn--sm btn--pen" data-copy="{{ $publicUrl }}">Linki kopyala</button>
        @elseif ($form->status === 'draft')
          <span class="muted">Yayınlanınca link açılır</span><a class="btn btn--sm btn--ghost" href="{{ route('formcraft.preview.form-edit', $formRoute) }}">Ayarlar</a>
        @else
          <span class="muted">Yeni yanıt kabul etmiyor</span><a class="btn btn--sm btn--ghost" href="{{ route('formcraft.preview.submissions', $formRoute) }}">Yanıtlar</a>
        @endif
      </div>
    </li>
  @empty
    @if (! $hasForms && $workspace)
      <li class="paper card" data-status="empty" style="--tilt:0deg">
        <span class="serial">No 0000</span>
        <p class="lbl muted">Henüz form yok</p>
        <h3><a href="{{ route('formcraft.preview.form-create', ['workspace' => $workspace->slug]) }}">Yeni form oluştur</a></h3>
        <span class="stamp stamp--draft" data-stamp>Boş</span>
        <dl><dt>Yanıt</dt><dt>Alan</dt><dd class="num">0</dd><dd class="num">0</dd></dl>
      </li>
    @endif
  @endforelse
</ul>
@if ($hasForms && $forms->isEmpty())
  <p role="status">Aramana uyan form bulunamadı.</p>
@elseif (! $workspace)
  <p role="status">Henüz bir çalışma alanına üye değilsin.</p>
@endif
