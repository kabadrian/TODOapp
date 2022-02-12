@extends('layouts.app')

@section('content')
    <h1>Upravenie úlohy: {{$todo->title}}</h1>

    <form method="POST" class="todo-create" action="{{route('todos.update', $todo->id)}}" class="col-12">
        @method('PUT')
        @csrf
        <label for="title">Názov</label> <br>
        <input type="text" class="col-12" name="title" id="title" value="{{$todo->title}}"> <br>
        <label for="description">Popis</label> <br>
        <textarea id="description" rows="4" class="col-12" name="description">{{$todo->description}}</textarea> <br>


        <label for="category">Kategória</label> <br>

        <div class="d-flex justify-content-between">
            <select id="category" name="category">
                @foreach($categories as $category)
                    <option value="{{$category->id}}"
                        @if($category==$todo->category)
                            selected
                        @endif
                    >{{$category->name}}</option>

                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">
                Upraviť
            </button>
        </div>
    </form>
@endsection
