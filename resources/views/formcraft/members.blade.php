@extends('layouts.formcraft')

@section('title', 'Üyeler · FormCraft')
@section('body-class', 'app')
@push('scripts')
@include('formcraft.scripts')
@endpush
@push('head')
<style>
  .layout { display: grid; grid-template-columns: minmax(0, 1fr) 24rem; gap: 2.5rem; align-items: start; }
  .roster .head { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.75rem; border-bottom: 2px solid var(--ink); }
  .person { display: grid; grid-template-columns: 3rem minmax(0, 1fr) 11rem auto; gap: 1.25rem; align-items: center; padding: 1.1rem 1.75rem; border-bottom: 1px solid var(--rule); }
  .av { width: 3rem; height: 3rem; border-radius: 50%; background: var(--canary); display: grid; place-items: center; font-weight: 800; }
  .person b { display: block; }
  .person small { color: var(--ink-2); }
  .role { border: 0; border-bottom: 2px solid var(--ink); background: transparent; font: inherit; padding: .5rem 0; min-height: 44px; }
  .owner { font-weight: 800; color: var(--stamp); letter-spacing: .12em; text-transform: uppercase; font-size: .78rem; font-family: var(--fc-font-display); font-variation-settings: "wdth" 72; }
  /* Invitations are envelopes: the invite form is one, pending invites stack below. */
  .env { position: relative; padding: 2rem 1.75rem 1.75rem; background: var(--canary); color: var(--ink); }
  .env::before { content: ""; position: absolute; inset: 0 0 auto 0; height: 3.25rem; background: linear-gradient(to bottom right, transparent 49.5%, rgb(20 22 28 / .14) 50%) left / 50% 100% no-repeat, linear-gradient(to bottom left, transparent 49.5%, rgb(20 22 28 / .14) 50%) right / 50% 100% no-repeat; }
  .env form { position: relative; display: grid; gap: 1.25rem; margin-top: 1rem; }
  .pending { margin-top: 2.5rem; }
  .pending h2 { font-size: .8rem; letter-spacing: .14em; text-transform: uppercase; font-family: var(--fc-font-display); font-variation-settings: "wdth" 72; color: var(--sc-ink-soft); margin: 0 0 1rem; }
  .inv { display: flex; justify-content: space-between; align-items: center; gap: 1rem; padding: 1rem 1.25rem; background: var(--white); color: var(--ink); margin-bottom: .6rem; transform: rotate(var(--r, 0deg)); }
  .inv small { display: block; color: var(--ink-2); }
  .readonly { margin-top: 1.5rem; padding: 1rem 1.25rem; border: 1px dashed rgb(255 255 255 / .35); color: var(--sc-ink-soft); font-size: .92rem; }
  @media (max-width: 960px) { .layout { grid-template-columns: 1fr; } .person { grid-template-columns: 3rem minmax(0, 1fr); } .nav { display: none; } }
</style>
@endpush

@section('content')
<header class="topbar">
  <a class="brand" href="{{ route('formcraft.home') }}"><b>FormCraft</b></a>
  <span class="ws">Kişisel alanın <span class="plan">{{ Auth::user()?->planName() ?? 'Ücretsiz' }}</span></span>
  <nav class="nav" aria-label="Çalışma alanı"><a href="{{ route('formcraft.preview.forms') }}">Formlar</a><a href="{{ route('formcraft.preview.members') }}" aria-current="page">Üyeler</a></nav>
  <span class="me"><i>DY</i>Deniz</span>
</header>
@yield('page')
@endsection
