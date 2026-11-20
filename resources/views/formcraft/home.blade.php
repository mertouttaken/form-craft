@extends('layouts.formcraft')

@section('title', 'FormCraft · Formu kur, linki paylaş')
@section('body-class', 'press-page')
@section('body-id', 'bas')
@push('head')
<link rel="stylesheet" href="{{ asset('formcraft/press.css') }}?v={{ filemtime(public_path('formcraft/press.css')) }}">
@endpush
@push('scripts')
<script src="{{ asset('formcraft/press.js') }}?v={{ filemtime(public_path('formcraft/press.js')) }}" defer></script>
@endpush

@section('content')
@yield('page')
@endsection
