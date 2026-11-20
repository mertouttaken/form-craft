@extends('layouts.formcraft')

@section('title', 'Form kurucu · FormCraft')
@section('body-class', 'app builder-app')
@push('head')
<link rel="stylesheet" href="{{ asset('formcraft/builder.css') }}">
@endpush

@section('content')
<header class="topbar">
  <a class="brand" href="{{ route('formcraft.home') }}"><b>FormCraft</b></a>
  <nav class="nav" aria-label="Çalışma alanı"><a href="{{ route('formcraft.preview.forms') }}">Formlar</a><a href="{{ route('formcraft.preview.members') }}">Üyeler</a></nav>
</header>
<livewire:workspaces.forms.builder />
@endsection
