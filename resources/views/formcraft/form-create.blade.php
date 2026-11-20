@extends('layouts.formcraft')

@section('title', 'Yeni form · FormCraft')
@section('body-class', 'app')
@push('scripts')
@include('formcraft.scripts')
@endpush
@push('head')
<style>
  /* One blank sheet in the middle of the desk; the questions are numbered boxes on it. */
  .sheet { max-width: 52rem; margin: 0 auto; padding: 3.5rem 4rem 0; }
  .q { padding: 3rem 0; border-top: 1px solid var(--rule); display: grid; grid-template-columns: 4rem 1fr; gap: 1.5rem; }
  .q:first-of-type { border-top: 2px solid var(--ink); }
  .q__no { font-size: 2.4rem; font-weight: 800; color: var(--stamp); font-family: var(--fc-font-display); font-variation-settings: "wdth" 72; line-height: 1; }
  .q h2 { margin: 0 0 .5rem; font-size: 1.6rem; font-weight: 750; font-family: var(--fc-font-display); font-variation-settings: "wdth" 105; }
  .q .input { font-size: 1.6rem; color: var(--pen); }
  .q .textarea { font-size: 1.15rem; color: var(--pen); }
  .submit { display: flex; justify-content: space-between; align-items: center; gap: 1rem; padding: 2rem 0 2.5rem; border-top: 2px solid var(--ink); }
  .stub { display: flex; justify-content: space-between; padding: 1rem 0 1.25rem; font-size: .9rem; color: var(--ink-2); }
  @media (max-width: 640px) { .sheet { padding: 2.5rem 1.25rem 0; } .q { grid-template-columns: 1fr; } .sheet .perf { margin-inline: -1.25rem !important; } .wrap { padding-inline: 1rem; } .nav { display: none; } .topbar { padding: 0 1rem; } }
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
