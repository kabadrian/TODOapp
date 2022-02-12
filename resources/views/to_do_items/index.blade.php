@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between">
        <h1>Todo zoznam</h1>
        <a href="{{route('todos.create')}}" class="btn btn-primary my-3">Pridať Todo</a>
    </div>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">Názov</th>
                <th scope="col">Kategoria</th>
                <th scope="col">Akcia</th>
            </tr>
        </thead>

        <tbody>
            @if(!empty($todos))
                @foreach($todos as $todo)
                    <tr>
                        <td>{{$todo->title}} </td>
                        <td>{{$todo->category->name}} </td>
                        <td>
                            <a href="#">Ukoncene</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
