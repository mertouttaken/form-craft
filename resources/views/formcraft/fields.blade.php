@extends('layouts.formcraft')

@section('title', 'Alanlar · FormCraft')
@section('body-class', 'app')
@push('scripts')
@include('formcraft.scripts')
@endpush
@push('head')
<style>
  .sheet { padding: 0; overflow: clip; }
  .sheet__head { display: flex; justify-content: space-between; align-items: center; gap: 1rem; padding: 1.5rem 2rem; border-bottom: 2px solid var(--ink); }
  /* Each field is a numbered row on the form, the way a printed form numbers its boxes. */
  .rows { list-style: none; margin: 0; padding: 0; }
  .row { display: grid; grid-template-columns: 4.5rem minmax(0, 1fr) 9rem 8rem auto; align-items: center; gap: 1.5rem; padding: 1.25rem 2rem; border-bottom: 1px solid var(--rule); }
  .row__no { font-size: 1.9rem; font-weight: 800; color: var(--stamp); font-family: var(--fc-font-display); font-variation-settings: "wdth" 72; }
  .row__label { font-size: 1.15rem; font-weight: 650; }
  .row__ph { color: var(--ink-2); font-size: .92rem; margin-top: .2rem; }
  .type { display: inline-flex; align-items: center; gap: .4rem; font-size: .72rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; font-family: var(--fc-font-display); font-variation-settings: "wdth" 72; padding: .3rem .55rem; border: 1px solid var(--ink); }
  .req { font-size: .8rem; font-weight: 700; color: var(--stamp); letter-spacing: .1em; text-transform: uppercase; font-family: var(--fc-font-display); font-variation-settings: "wdth" 72; }
  .opt { font-size: .8rem; color: var(--ink-2); }
  .acts { display: flex; gap: .4rem; justify-content: flex-end; }
  .acts form { margin: 0; }
  .sq { width: 40px; height: 40px; display: grid; place-items: center; border: 1px solid var(--ink); background: transparent; cursor: pointer; color: var(--ink); text-decoration: none; }
  .sq:hover { background: var(--ink); color: var(--white); }
  .sq[disabled] { opacity: .3; cursor: not-allowed; background: transparent; color: var(--ink); }
  .sq--danger { border-color: var(--stamp); color: var(--stamp); }
  .sq--danger:hover { background: var(--stamp); color: #fff; }
  .limit { display: flex; align-items: center; gap: 1rem; padding: 1.25rem 2rem; }
  .meter { flex: 1; height: 8px; background: var(--rule-2); position: relative; max-width: 20rem; }
  .meter i { position: absolute; inset: 0 auto 0 0; width: 60%; background: var(--pen); }
  .flash { display: flex; gap: .75rem; align-items: center; margin-bottom: 1.5rem; padding: .9rem 1.1rem; background: var(--white); color: var(--ink); border-left: 6px solid var(--pen); }
  @media (max-width: 900px) { .row { grid-template-columns: 3rem minmax(0, 1fr) auto; } .row .type, .row .req-col { display: none; } .nav { display: none; } }
  @media (max-width: 620px) {
    .row { grid-template-columns: 2.2rem minmax(0, 1fr); padding: .9rem 1rem; gap: .6rem; }
    .acts { grid-column: 2; justify-content: start; flex-wrap: wrap; }
    .sheet__head, .limit { padding-inline: 1rem; }
  }
</style>
@endpush

@section('content')
<header class="topbar">
  <a class="brand" href="{{ route('formcraft.home') }}"><b>FormCraft</b></a>
  <span class="ws">Kişisel alanın <span class="plan">{{ Auth::user()?->planName() ?? 'Ücretsiz' }}</span></span>
  <nav class="nav" aria-label="Çalışma alanı"><a href="{{ route('formcraft.preview.forms') }}" aria-current="page">Formlar</a><a href="{{ route('formcraft.preview.members') }}">Üyeler</a></nav>
  <span class="me"><i>{{ substr(Auth::user()?->name, 0, 1) }}</i>{{ Auth::user()?->name ?? 'Deniz' }}</span>
</header>
@yield('page')
@endsection
