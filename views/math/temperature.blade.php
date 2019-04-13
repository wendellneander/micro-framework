@extends('template', ['title' => 'Temperature'])

@section('content')

    <div class="pt-5">

        <h1 class="pb-2">Fahrenheit: {{ $fahrenheit }}</h1>
        <h2 class="pb-2">Celsius: {{ $celsius }}</h2>

    </div>

@endsection
