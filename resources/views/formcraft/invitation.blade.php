@extends('layouts.formcraft')

@section('title', 'Davet · FormCraft')
@push('head')
<style>
  body { background: var(--desk); color: var(--white); }
  .invitation-stage {
    min-height: 100svh; display: grid; place-items: center;
    padding-block: clamp(1.25rem, 4vh, 3rem);
  }
  .env {
    --pocket-height: clamp(4.5rem, 13vh, 6rem);
    position: relative; width: min(36rem, 92vw);
    padding-bottom: var(--pocket-height); isolation: isolate;
    animation: envelope-settle 620ms cubic-bezier(.23, .72, .24, 1) both;
  }
  .env__front, .env__flap {
    position: absolute; inset-inline: 0; bottom: 0;
    height: var(--pocket-height); pointer-events: none;
  }
  .env__front {
    z-index: 1;
    background: linear-gradient(155deg, transparent 49%, color-mix(in srgb, var(--fc-gold) 14%, transparent) 50%, transparent 51%) left / 51% 100% no-repeat,
                linear-gradient(205deg, transparent 49%, color-mix(in srgb, var(--fc-gold) 14%, transparent) 50%, transparent 51%) right / 51% 100% no-repeat,
                var(--canary);
    box-shadow: 0 1.5rem 2.5rem -1.25rem var(--fc-navy-deep);
    display: flex; justify-content: end; align-items: end; padding: .6rem .85rem;
  }
  .env__flap {
    z-index: 2; transform-origin: top;
    filter: drop-shadow(0 3px 1px color-mix(in srgb, var(--fc-ink) 26%, transparent));
    animation: envelope-open 560ms cubic-bezier(.5, .04, .24, 1) 70ms both;
  }
  .env__flap::before {
    content: ""; position: absolute; inset: 0;
    background: linear-gradient(var(--fc-canary), var(--fc-canary-2));
    clip-path: polygon(0 0, 100% 0, 51% 95%, 49% 95%);
  }
  /* The sleeve cuts off the part of the letter still inside the pocket. */
  .env__sleeve {
    position: relative; z-index: 3; overflow: clip;
    padding: 1rem 6% .4rem;
  }
  .letter {
    padding: clamp(1rem, 3.2vw, 1.75rem);
    animation: invitation-rise 900ms cubic-bezier(.22, .72, .23, 1) 360ms both;
  }
  .letter .serial { position: static; display: block; margin-bottom: .55rem; }
  .letter h1 { margin: .5rem 0 .65rem; font-size: clamp(1.55rem, 1rem + 1.6vw, 2.2rem); font-weight: 800; font-family: var(--fc-font-display); font-variation-settings: "wdth" 110; line-height: 1.05; }
  .letter .acts { display: flex; flex-wrap: wrap; gap: .5rem; margin-top: .85rem; }
  .letter .note { margin: .65rem 0 0; color: var(--ink-2); font-size: .8rem; }
  .postmark { --r: -5deg; font-size: .7rem; }

  @keyframes envelope-settle {
    from { transform: translateY(-21%); }
    to { transform: translateY(0); }
  }
  @keyframes envelope-open {
    from { transform: perspective(700px) rotateX(0); }
    to { transform: perspective(700px) rotateX(-168deg); }
  }
  @keyframes invitation-rise {
    from { transform: translateY(calc(100% + .75rem)); }
    to { transform: translateY(0); }
  }

  @media (prefers-reduced-motion: reduce) {
    .env { animation: none; }
    .env__flap { animation: envelope-open-soft 380ms ease both; }
    .letter { animation: invitation-reveal 340ms ease-out 200ms both; }
  }
  @keyframes envelope-open-soft {
    0% { transform: perspective(700px) rotateX(0); opacity: 1; }
    49% { transform: perspective(700px) rotateX(0); opacity: 0; }
    50% { transform: perspective(700px) rotateX(-168deg); opacity: 0; }
    100% { transform: perspective(700px) rotateX(-168deg); opacity: 1; }
  }
  @keyframes invitation-reveal {
    from { opacity: 0; transform: translateY(.5rem); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* Make the controls visible immediately if someone tabs into the letter. */
  .env:focus-within, .env:focus-within .letter { transform: none !important; opacity: 1 !important; }
</style>
@endpush

@section('content')
@yield('page')
@endsection
