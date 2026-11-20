<main>
  <section data-sc-act="pin" data-sc-span="1.2">
    <div data-sc-stage class="stage">
      <article class="receipt" aria-labelledby="t">
        <div class="receipt__body paper paper--pink">
          <p class="lbl muted">Aralık Buluşmasına kayıt</p>
          @if ($demoSubmission)
            <h1 class="d-lg receipt-title" id="t">Kaydın alındı.</h1>
            <span class="stamp" data-stamp>Alındı</span>
            <dl>
              <dt>Gönderim</dt><dd class="num">{{ $demoSubmission['submittedAt'] }}</dd>
              <dt>Ad soyad</dt><dd class="pen">{{ $demoSubmission['name'] }}</dd>
              <dt>Seçtiğin oturum</dt><dd class="pen" data-receipt-session>{{ $demoSubmission['session'] }}</dd>
            </dl>
            <a class="btn btn--pen receipt-link" href="{{ route('formcraft.preview.submissions') }}">Yanıt listesinde gör ↗</a>
          @else
            <h1 class="d-lg receipt-title" id="t">Henüz örnek gönderim yok.</h1>
            <a class="btn btn--pen receipt-link" href="{{ route('formcraft.preview.public-form') }}">Aralık Buluşması formuna git ↗</a>
          @endif
        </div>
        <div class="stub paper paper--pink"><span class="lbl">Örnek makbuz</span><b>FormCraft</b></div>
      </article>
    </div>
  </section>
</main>
