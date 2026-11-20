@extends('layouts.formcraft')

@section('title', 'Davet · FormCraft')
@push('scripts')
@include('formcraft.scripts')
@endpush
@push('head')
<style>
  body { background: var(--desk); color: var(--white); }
  .stage { display: grid; place-items: center; background: var(--desk); perspective: 1400px; }
  .env { position: relative; width: min(36rem, 92vw); aspect-ratio: 16/10; }
  .env__back { position: absolute; inset: 0; background: #E9D489; }
  /* The flap opens with scroll, then the letter rises out of the envelope. */
  .env__flap { position: absolute; inset: 0 0 45% 0; background: var(--canary); clip-path: polygon(0 0, 100% 0, 50% 100%); transform-origin: top; z-index: 3;
    transform: rotateX(calc(min(1, var(--sc-p, 0) * 2.2) * 178deg)); }
  .env__front { position: absolute; inset: 0; z-index: 2; background: var(--canary); clip-path: polygon(0 32%, 50% 66%, 100% 32%, 100% 100%, 0 100%); }
  .letter { position: absolute; left: 6%; right: 6%; top: 8%; height: 120%; z-index: 1; padding: 2rem 2rem; color: var(--ink);
    transform: translateY(calc(max(0, var(--sc-p, 0) - .35) * -95%)); }
  .letter h1 { margin: .75rem 0 1rem; font-size: clamp(1.6rem, 1rem + 1.6vw, 2.3rem); font-weight: 800; font-variation-settings: "wdth" 110; line-height: 1.05; }
  .letter .acts { display: flex; gap: .75rem; margin-top: 1.5rem; }
  .letter .z { z-index: 4; position: relative; }
  .postmark { position: absolute; z-index: 4; right: 1.5rem; bottom: 1.25rem; color: var(--ink); --r: -8deg; font-size: .85rem; }
  .note { position: absolute; bottom: 6vh; left: 0; right: 0; text-align: center; color: var(--sc-ink-soft); }
  @media (prefers-reduced-motion: reduce) { .env__flap { transform: rotateX(178deg); } .letter { transform: translateY(-95%); } }
</style>
@endpush

@section('content')
<livewire:forms.invitations />
@endsection
