@extends('layouts.formcraft')

@section('title', 'Teşekkürler · Aralık Buluşmasına kayıt')
@push('scripts')
@include('formcraft.scripts')
@endpush
@push('head')
<style>
  body { background: var(--canary); color: var(--ink); }
  .stage { display: grid; place-items: center; background: var(--canary); }
  .receipt {
    --tear: clamp(0, (var(--sc-p, 0) - .24) / .64, 1);
    width: min(34rem, 90vw); padding-bottom: 4rem;
  }
  .receipt__body { z-index: 1; padding: 2.5rem 2.5rem 1.65rem; }
  .receipt-title { margin: .75rem 0 0; }
  .receipt__body .stamp { margin-top: .9rem; font-size: 1.08rem; --r: -6deg; }
  .receipt-link { margin-top: 1.25rem; }
  .receipt dl { margin: 1.6rem 0 0; display: grid; grid-template-columns: auto 1fr; gap: .6rem 1.5rem; font-size: .95rem; }
  .receipt dt { color: var(--ink-2); font-size: .72rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; font-variation-settings: "wdth" 72; padding-top: .2rem; }
  .receipt dd { margin: 0; overflow-wrap: anywhere; }
  .stub {
    padding: 1.25rem 2.5rem; display: flex; flex-wrap: wrap; gap: .5rem 1rem;
    justify-content: space-between; align-items: center; transform-origin: 10% 0;
    transform: translate(calc(var(--tear) * 7px), calc(var(--tear) * 29px)) rotate(calc(var(--tear) * 4deg));
  }
  .receipt__body::after, .stub::before {
    content: ""; position: absolute; inset-inline: 0; height: 3.5px; pointer-events: none;
    background: radial-gradient(circle at 7px 100%, var(--canary) 3px, transparent 3.5px) 0 0 / 14px 100% repeat-x;
  }
  .receipt__body::after { bottom: 0; }
  .stub::before { top: 0; transform: scaleY(-1); }
  .stub b { font-size: 1.6rem; font-variation-settings: "wdth" 72; color: var(--stamp); }
  @media (max-width: 460px) {
    .receipt__body, .stub { padding-inline: 1.25rem; }
    .receipt__body { padding-block: 1.65rem; }
    .receipt dl { column-gap: .8rem; }
  }
  @media (max-height: 560px) { .stage { height: auto; min-height: 100svh; padding-top: 1.5rem; } }
  @media (prefers-reduced-motion: reduce) { .receipt { --tear: 0; padding-bottom: 0; } }
</style>
@endpush

@section('content')
<livewire:forms.thanks />
@endsection
