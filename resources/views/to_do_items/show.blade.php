@extends('layouts.app')

@section('content')

    <h1 class="mt-3">Detail úlohy: {{$todo->title}}</h1>

    <div class="my-3 p-4 bg-secondary text-white rounded">

        <div class="h4">Autor úlohy: {{$todo->user->name}}</div>

        <div class="h3">Názov úlohy</div>
        <hr>
        <p>{{$todo->title}}</p>

        <div class="h3">Detail úlohy</div>
        <hr>
        <p>{{$todo->description}}</p>

    </div>

@endsection
