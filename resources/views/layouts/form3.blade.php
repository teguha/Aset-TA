@extends('layouts.app')

@section('content')
@section('content-header')
    @include('layouts.base.subheadernobuttons')
@show
@php
$colors = [
1 => 'primary',
2 => 'info',
];
@endphp
<div class="{{ $container ?? 'container-fluid' }}">
	<form action="@yield('action', '#')" method="POST" autocomplete="@yield('autocomplete', 'off')">
    @csrf
    @yield('card-body')
	</form>
</div>
@endsection