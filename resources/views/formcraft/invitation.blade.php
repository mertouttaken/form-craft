@extends('layouts.formcraft')

@section('title', 'Davet · FormCraft')
@push('scripts')
@include('formcraft.scripts')
<script>
  (() => {
    const invitation = document.querySelector(".invitation");
    const toggle = invitation.querySelector(".env__motion");
    const reducedMotion = matchMedia("(prefers-reduced-motion: reduce)");
    const preferenceKey = "formcraft.invitationMotion";
    let enabled = false;

    try {
      enabled = localStorage.getItem(preferenceKey) === "enabled";
    } catch {}

    function renderMotionPreference() {
      invitation.toggleAttribute("data-motion-enabled", enabled);
      toggle.hidden = !reducedMotion.matches;
      toggle.textContent = enabled ? "Animasyonu kapat" : "Animasyonu aç";
    }

    toggle.addEventListener("click", () => {
      enabled = !enabled;
      renderMotionPreference();
      try {
        localStorage.setItem(preferenceKey, enabled ? "enabled" : "disabled");
      } catch {}
      if (enabled) window.scrollTo({ top: 0, behavior: "instant" });
    });

    reducedMotion.addEventListener("change", renderMotionPreference);
    renderMotionPreference();
  })();
</script>
@endpush
@push('head')
<style>
  body { background: var(--desk); color: var(--white); }
  .stage { display: grid; place-items: center; padding-block: 1.25rem; background: var(--desk); }
  .invitation {
    --open: 1;
    --lift: 1;
    display: grid; justify-items: center; gap: 1.45rem;
    width: min(36rem, 92vw);
  }
  .sc-act--pinned .invitation {
    --open: clamp(0, (var(--sc-p, 0) - .025) / .41, 1);
    --lift: clamp(0, (var(--sc-p, 0) - .24) / .67, 1);
  }
  .env {
    --pocket-height: clamp(4.5rem, 12vh, 5.75rem);
    --paper-rise: clamp(38px, 11vh, 86px);
    position: relative; width: 100%; padding-top: var(--paper-rise);
    padding-bottom: calc(var(--pocket-height) + .5rem);
    isolation: isolate;
  }
  .env__back, .env__front, .env__flap {
    position: absolute; inset-inline: 0; pointer-events: none;
    translate: 0 calc(var(--lift) * .65rem);
  }
  .env__back {
    bottom: 0; height: calc(var(--pocket-height) + 2.2rem);
    background: linear-gradient(145deg, #e8d396, #cbb36c);
    box-shadow: 0 1.5rem 2.5rem -1.25rem #080d1e;
  }
  .env__flap {
    bottom: .35rem; height: var(--pocket-height); z-index: 3;
    transform-origin: top;
    transform: perspective(700px) rotateX(calc(var(--open) * -168deg));
    filter: drop-shadow(0 3px 1px #58431e42);
  }
  .env__flap::before {
    content: ""; position: absolute; inset: 0;
    background: linear-gradient(#efdba0, #dfc789);
    clip-path: polygon(0 0, 100% 0, 51% 100%, 49% 100%);
  }
  .env__front {
    bottom: 0; height: var(--pocket-height); z-index: 2;
    background: linear-gradient(155deg, transparent 49%, #966f3419 50%, transparent 51%) left / 51% 100% no-repeat,
                linear-gradient(205deg, transparent 49%, #966f3419 50%, transparent 51%) right / 51% 100% no-repeat,
                var(--canary);
    display: flex; justify-content: end; align-items: end; padding: .6rem .85rem;
  }
  .letter {
    margin-inline: 6%; padding: clamp(1rem, 3.2vw, 1.75rem);
    z-index: 4; transform: translateY(calc(var(--lift) * var(--paper-rise) * -1));
  }
  .letter .serial { position: static; display: block; margin-bottom: .55rem; }
  .letter h1 { margin: .5rem 0 .65rem; font-size: clamp(1.55rem, 1rem + 1.6vw, 2.2rem); font-weight: 800; font-variation-settings: "wdth" 110; line-height: 1.05; }
  .letter .acts { display: flex; flex-wrap: wrap; gap: .5rem; margin-top: .85rem; }
  .letter .note { margin: .65rem 0 0; color: var(--ink-2); font-size: .8rem; }
  .postmark { position: relative; z-index: 1; --r: -5deg; font-size: .7rem; }
  .env__controls { display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: .5rem 1rem; width: 100%; }
  .env__cue { display: none; margin: 0; color: var(--sc-ink-soft); }
  .sc-act--pinned .env__cue { display: block; opacity: calc(1 - var(--lift)); }
  .env__motion {
    color: var(--white); background: none; border: 1px solid #ffffff4d;
    font: inherit; font-size: .82rem; padding: .45rem .85rem; cursor: pointer;
  }
  .env__motion:hover { background: #ffffff19; }
  .env__motion:focus-visible { outline-color: var(--canary); }
  @media (max-height: 760px) { .env { --paper-rise: clamp(28px, 8vh, 60px); } }
  @media (max-height: 660px) { .stage { height: auto; min-height: 100svh; } }
  @media (prefers-reduced-motion: reduce) {
    .sc-act--pinned .invitation:not([data-motion-enabled]) { --open: 1; --lift: 1; }
    .invitation:not([data-motion-enabled]) .env__cue { display: none; }
    .env__controls { min-height: 2.35rem; }
  }
</style>
@endpush

@section('content')
<livewire:forms.invitations />
@endsection
