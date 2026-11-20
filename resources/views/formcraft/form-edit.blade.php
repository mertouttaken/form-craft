@extends('layouts.formcraft')

@section('title', 'Form ayarları · FormCraft')
@section('body-class', 'app')
@push('scripts')
@include('formcraft.scripts')
@endpush
@push('head')
<style>
  .layout { display: grid; grid-template-columns: 15rem minmax(0, 1fr); gap: 3rem; align-items: start; }
  /* Folio: the chapter index in the margin, sticky. */
  .folio { position: sticky; top: 6rem; display: grid; gap: .25rem; }
  .folio a { display: flex; gap: .75rem; padding: .55rem 0; text-decoration: none; color: var(--sc-ink-soft); border-bottom: 1px solid rgb(255 255 255 / .1); font-size: .95rem; }
  .folio a b { color: var(--canary); font-family: var(--fc-font-display); font-variation-settings: "wdth" 72; }
  .folio a:hover { color: var(--white); }
  .sheet { padding: 0 3rem; }
  .chap { padding: 3rem 0; border-top: 1px solid var(--rule); display: grid; grid-template-columns: 15rem minmax(0, 1fr); gap: 2.5rem; }
  .chap:first-child { border-top: 0; }
  .chap h2 { margin: 0; font-size: 1.35rem; font-weight: 750; font-family: var(--fc-font-display); font-variation-settings: "wdth" 105; }
  .chap .field__help { margin-top: .5rem; }
  .stack { display: grid; gap: 1.75rem; }
  .status { display: grid; grid-template-columns: repeat(3, 1fr); gap: .75rem; }
  .status label { position: relative; display: grid; gap: .4rem; padding: 1rem; border: 2px solid var(--rule); cursor: pointer; }
  .status input { position: absolute; opacity: 0; }
  .status label:has(input:checked) { border-color: var(--ink); background: rgb(246 231 161 / .45); }
  .status label:has(input:focus-visible) { outline: 2px solid var(--pen); outline-offset: 2px; }
  .status small { color: var(--ink-2); }
  .preview { display: flex; align-items: center; gap: 1.5rem; margin-top: 1.25rem; }
  .danger { border: 2px solid var(--stamp); padding: 1.25rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
  .savebar { position: sticky; bottom: 0; display: flex; justify-content: flex-end; gap: .75rem; padding: 1.25rem 3rem; margin: 0 -3rem; background: var(--white); border-top: 2px solid var(--ink); }
  @media (max-width: 900px) { .layout, .chap { grid-template-columns: 1fr; } .folio { display: none; } .sheet { padding: 0 1.25rem; } .savebar { margin: 0 -1.25rem; padding: 1rem 1.25rem; } .status { grid-template-columns: 1fr; } .nav { display: none; } }
</style>
@endpush

@section('content')
<header class="topbar">
  <a class="brand" href="{{ route('formcraft.home') }}"><b>FormCraft</b></a>
  <span class="ws">Kişisel alanın <span class="plan">{{ Auth::user()?->planName() ?? 'Ücretsiz' }}</span></span>
  <nav class="nav" aria-label="Çalışma alanı"><a href="{{ route('formcraft.preview.forms') }}" aria-current="page">Formlar</a><a href="{{ route('formcraft.preview.members') }}">Üyeler</a></nav>
  <span class="me"><i>DY</i>Deniz</span>
</header>
@yield('page')
@endsection
