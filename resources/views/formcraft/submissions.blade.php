@extends('layouts.formcraft')

@section('title', 'Yanıtlar · FormCraft')
@section('body-class', 'app')
@push('scripts')
@include('formcraft.scripts')
@endpush
@push('head')
<style>
  .bar { display: flex; flex-wrap: wrap; gap: 1rem 2rem; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 2px solid var(--ink); }
  .bar .search { display: flex; align-items: center; gap: .5rem; border-bottom: 2px solid var(--ink); min-width: 16rem; }
  .bar .search input { border: 0; background: transparent; font: inherit; padding: .5rem 0; width: 100%; }
  .bar .range { display: flex; gap: .5rem; align-items: center; }
  .bar .range input { border: 0; border-bottom: 2px solid var(--ink); font: inherit; padding: .4rem 0; background: transparent; }
  .bar .count { margin-left: auto; }
  /* The table's head sticks under the top bar; columns come from the form's own fields. */
  .scroller { overflow-x: auto; }
  .table td:first-child, .table th:first-child { padding-left: 1.5rem; }
  .table tbody tr { cursor: pointer; }
  .table td.pen { font-size: 1.15rem; }
  .pager { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-top: 2px solid var(--ink); font-size: .92rem; }
  .pager nav { display: flex; gap: .3rem; }
  .pager a { min-width: 40px; height: 40px; display: grid; place-items: center; border: 1px solid var(--rule); text-decoration: none; }
  .pager a[aria-current] { background: var(--ink); color: var(--white); border-color: var(--ink); }
  dialog { border: 0; padding: 0; max-width: 34rem; width: 92vw; }
  dialog::backdrop { background: rgb(13 19 44 / .7); }
  .detail { padding: 2.25rem 2rem 0; }
  .detail dl { margin: 1.5rem 0 0; }
  .detail dl > div { padding: .85rem 0; border-top: 1px solid var(--rule); }
  .detail dt { font-size: .72rem; letter-spacing: .12em; font-weight: 700; text-transform: uppercase; font-family: var(--fc-font-display); font-variation-settings: "wdth" 72; color: var(--ink-2); }
  .detail dd { margin: .2rem 0 0; }
  .detail .meta { display: flex; justify-content: space-between; padding: 1rem 0 1.25rem; font-size: .85rem; color: var(--ink-2); }
  .empty { padding: 5rem 2rem; text-align: center; }
  @media (max-width: 760px) { .nav { display: none; } }
  @media (max-width: 580px) {
    .bar .search { min-width: 0; width: 100%; }
    .bar .range, .pager { flex-wrap: wrap; }
    .pager { padding-inline: 1rem; gap: 10px; }
    .pager a { min-width: 34px; height: 34px; }
  }
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
