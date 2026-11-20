@extends('layouts.formcraft')

@section('title', 'Yeni alan · FormCraft')
@section('body-class', 'app')
@push('scripts')
@include('formcraft.scripts')
@endpush
@push('head')
<style>
  .sheet { max-width: 60rem; margin: 0 auto; padding: 3rem 3.5rem 0; }
  .step { padding: 2.5rem 0; border-top: 1px solid var(--rule); }
  .step:first-of-type { border-top: 2px solid var(--ink); }
  .step h2 { margin: 0 0 1.25rem; font-size: 1.35rem; font-weight: 750; font-variation-settings: "wdth" 105; }
  .step h2 b { color: var(--stamp); margin-right: .5rem; }
  /* Type palette: eight stamps to pick from. */
  .types { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: .75rem; }
  .types label { position: relative; display: grid; gap: .6rem; padding: 1rem; border: 2px solid var(--rule); cursor: pointer; min-height: 6.5rem; }
  .types input { position: absolute; opacity: 0; }
  .types label:has(input:checked) { border-color: var(--pen); background: rgb(29 59 168 / .06); }
  .types label:has(input:checked) b { color: var(--pen); }
  .types label:has(input:focus-visible) { outline: 2px solid var(--pen); outline-offset: 2px; }
  .types svg { width: 26px; height: 26px; }
  .types b { font-weight: 750; }
  .types small { color: var(--ink-2); font-size: .82rem; }
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.75rem 2rem; }
  .opts { display: grid; gap: .6rem; }
  .opt { display: flex; gap: .6rem; align-items: center; }
  .opt .input { flex: 1; }
  .rules { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1.5rem; }
  .submit { display: flex; justify-content: flex-end; gap: .75rem; padding: 2rem 0; border-top: 2px solid var(--ink); }
  .x { width: 40px; height: 40px; border: 1px solid var(--rule); background: transparent; cursor: pointer; }
  @media (max-width: 760px) { .types { grid-template-columns: 1fr 1fr; } .grid2, .rules { grid-template-columns: 1fr; } .sheet { padding: 2rem 1.25rem 0; } .nav { display: none; } }
</style>
@endpush

@section('content')
<header class="topbar">
  <a class="brand" href="{{ route('formcraft.home') }}"><b>FormCraft</b></a>
  <span class="ws">Pro ekibi <span class="plan">Pro</span></span>
  <nav class="nav" aria-label="Çalışma alanı"><a href="{{ route('formcraft.preview.forms') }}" aria-current="page">Formlar</a><a href="{{ route('formcraft.preview.members') }}">Üyeler</a></nav>
  <span class="me"><i>DY</i>Deniz</span>
</header>
<livewire:workspaces.forms.fields.create />
@endsection
