@extends('layouts.formcraft')

@section('title', 'Formlar · FormCraft')
@section('body-class', 'app')
@push('scripts')
@include('formcraft.scripts')
@endpush
@push('head')
@include('formcraft.form-list-styles')
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
