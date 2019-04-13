@extends('template', ['title' => 'Calcular Nota'])

@section('content')

    <div class="pt-5">

        <h1 class="pb-2">{{ $message }}</h1>
        <h2 class="pb-2">Nota {{ $score }}</h2>

    </div>

@endsection
