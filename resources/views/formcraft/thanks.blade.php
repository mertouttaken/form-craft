@extends('layouts.formcraft')

@section('title', 'Teşekkürler · Aralık Buluşmasına kayıt')
@push('scripts')
@include('formcraft.scripts')
@endpush
@push('head')
<style>
  /* The receipt: a pink copy with a stub that tears off as the visitor scrolls. */
  body { background: var(--canary); color: var(--ink); }
  .stage { display: grid; place-items: center; background: var(--canary); }
  .receipt { width: min(34rem, 90vw); }
  .receipt__body { padding: 3rem 2.5rem 2rem; }
  .receipt__body .stamp { position: absolute; right: 2rem; top: 4.5rem; font-size: 2.2rem; --r: -10deg; }
  .receipt dl { margin: 2rem 0 0; display: grid; grid-template-columns: auto 1fr; gap: .6rem 1.5rem; font-size: .95rem; }
  .receipt dt { color: var(--ink-2); font-size: .72rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; font-variation-settings: "wdth" 72; padding-top: .2rem; }
  .receipt dd { margin: 0; }
  /* The stub's tear is driven by the act's scroll progress. */
  .stub {
    padding: 1.25rem 2.5rem 1.75rem; display: flex; justify-content: space-between; align-items: center;
    transform-origin: 10% 0;
    transform: translateY(calc(max(0, var(--sc-p, 0) - .35) * 70vh)) rotate(calc(max(0, var(--sc-p, 0) - .35) * 22deg));
    opacity: calc(1 - max(0, var(--sc-p, 0) - .75) * 4);
  }
  .stub b { font-size: 1.6rem; font-variation-settings: "wdth" 72; color: var(--stamp); }
  .hint { position: absolute; bottom: 8vh; left: 0; right: 0; text-align: center; color: var(--ink-2); }
  @media (prefers-reduced-motion: reduce) { .stub { transform: none; opacity: 1; } }
</style>
@endpush

@section('content')
<livewire:forms.thanks />
@endsection
