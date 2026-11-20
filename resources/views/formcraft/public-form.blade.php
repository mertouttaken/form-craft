@extends('layouts.formcraft')

@section('title', 'Aralık Buluşmasına kayıt')
@push('scripts')
@include('formcraft.scripts')
@endpush
@push('head')
<style>
  /* The respondent's copy: the whole page is the canary sheet. One question per screen. */
  body { background: var(--canary); color: var(--ink); --sc-accent: var(--pen); }
  :focus-visible { outline-color: var(--pen); }
  [data-sc-progress] { background: var(--pen); height: 4px; }
  .mast { position: fixed; inset: 0 0 auto 0; z-index: 20; display: flex; justify-content: space-between; align-items: center; padding: 1rem 3rem; background: color-mix(in oklab, var(--canary) 92%, transparent); border-bottom: 1px solid var(--rule); }
  .mast b { font-weight: 750; font-variation-settings: "wdth" 105; }
  .q { min-height: 100svh; display: grid; align-items: center; padding: 6rem 8vw; border-bottom: 1px dashed var(--rule); }
  .q__in { display: grid; grid-template-columns: 7rem minmax(0, 46rem); gap: 2rem; }
  .q__no { font-size: 4rem; font-weight: 800; line-height: .9; color: var(--stamp); font-variation-settings: "wdth" 72; }
  .q label, .q legend { font-size: clamp(1.8rem, 1rem + 2vw, 2.8rem); font-weight: 750; font-variation-settings: "wdth" 108; line-height: 1.05; letter-spacing: -.01em; padding: 0; }
  .q .req { color: var(--stamp); }
  .q .field__help { margin: .8rem 0 1.75rem; font-size: 1.05rem; }
  .q .input { font-size: 1.6rem; border-bottom-width: 3px; }
  .q .textarea { font-size: 1.2rem; border-width: 3px; }
  .q fieldset { border: 0; margin: 0; padding: 0; }
  .choices { display: grid; gap: .6rem; max-width: 30rem; }
  .choices label { display: flex; align-items: center; gap: .9rem; font-size: 1.2rem !important; font-weight: 600 !important; padding: .8rem 1rem; border: 2px solid var(--ink); cursor: pointer; letter-spacing: 0 !important; }
  .choices label:has(input:checked) { background: var(--pen); color: #fff; border-color: var(--pen); }
  .choices input { width: 1.2rem; height: 1.2rem; accent-color: #fff; }
  .choices kbd { margin-left: auto; font: inherit; font-size: .72rem; border: 1px solid currentColor; padding: .1rem .4rem; opacity: .6; }
  .next { margin-top: 2rem; display: flex; gap: 1rem; align-items: center; color: var(--ink-2); font-size: .9rem; }
  .intro .d-xl { max-width: 13ch; }
  .intro p { font-size: 1.25rem; max-width: 36ch; margin: 1.5rem 0 2rem; }
  .send { display: grid; gap: 1.5rem; justify-items: start; }
  .hp { position: absolute; left: -9999px; }
  .powered { text-align: center; padding: 2rem; font-size: .85rem; color: var(--ink-2); }
  @media (max-width: 700px) { .q__in { grid-template-columns: 1fr; gap: .75rem; } .q__no { font-size: 2.4rem; } .mast { padding: 1rem; } .q { padding: 5rem 1.25rem; } }
</style>
@endpush

@section('content')
<livewire:forms.index />
@endsection
