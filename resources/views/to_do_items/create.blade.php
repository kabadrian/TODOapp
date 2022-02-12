@extends('layouts.app')

@section('content')
    <h1>Vytvorenie novej todo položky</h1>

    <form method="POST" class="todo-create" action="{{route('todos.store')}}" class="col-12">
        @csrf
        <label for="title">Názov</label> <br>
        <input type="text" class="col-12" name="title" id="title" value="{{old('title')}}"> <br>
        <label for="description">Popis</label> <br>
        <textarea id="description" rows="4" class="col-12" name="description">{{old('description')}}</textarea> <br>


        <label for="category">Kategória</label> <br>

        <div class="d-flex justify-content-between">
            <select id="category" name="category">
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">
                Vytvoriť
            </button>
        </div>
    </form>
@endsection
