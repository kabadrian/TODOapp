@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between">
        <h1>Todo zoznam</h1>
        <a href="{{route('todos.create')}}" class="btn btn-primary my-3">Pridať Todo</a>
    </div>

    <form class="row  my-2" method="GET" action="{{route('todos.index')}}">
        <div class="h4 me-2 col-auto">Filtrovanie:</div>
        <select class=" col-auto" aria-label="Kategória" name="category">
            <option value="0">všetky</option>

                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
        </select>
        <div class="col-auto d-flex">
            <input class="mt-2 ms-1" type="checkbox" name="mine" id="mine">
            <label class="mt-2 me-1 ms-2" for="mine">Moje</label>
        </div>
        <div class="col-auto d-flex">
            <input class="mt-2 ms-1" type="checkbox" name="shared" id="shared">
            <label class="mt-2 me-1 ms-2" for="shared">Zdieľané</label>
        </div>
        <div class="col-auto d-flex">
            <input class="mt-2 ms-1" type="checkbox" name="completed" id="completed">
            <label class="mt-2 me-1 ms-2" for="completed">Dokončené</label>
        </div>

        <button type="submit" class="btn btn-secondary ms-3 col-auto">Filtrovať</button>


    </form>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="col-1">Splnené</th>
                <th scope="col">Názov</th>
                <th scope="col">Kategoria</th>
                <th scope="col">Akcia</th>
            </tr>
        </thead>

        <tbody>
            @if(!empty($todos))
                @foreach($todos as $todo)
                    <tr>
                        <td class="col-1 done-cell">
                            <form method="POST" action="{{route('todos.completed', $todo->id)}}">
                                @csrf
                                <input type="checkbox" onChange="this.form.submit()"
                                @if(isset($todo->completed_at))
                                    checked
                                @endif> </form>
                            </form>
                        </td>
                        <td class="col-5">{{$todo->title}} </td>
                        <td class="col-3">
                            @isset($todo->category)
                                {{$todo->category->name}}
                            @endisset
                        </td>
                        <td class="col-3">
                            <div class="d-flex justify-content-between">
                                <div class="btn-group" role="group">
                                    <a class="btn btn-info me-2" href="{{route('todos.show', $todo->id)}}">Náhľad</a>
                                    @auth
                                        @can('update', $todo)
                                            <a class="btn btn-warning me-2" href="{{route('todos.edit', $todo->id)}}">Upraviť</a>
                                        @endcan
                                    @else
                                        <a class="btn btn-warning me-2" href="{{route('todos.edit', $todo->id)}}">Upraviť</a>
                                    @endauth

                                    <!-- User has to be logged in to share tasks-->
                                    @auth
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#shareTodoModal{{$todo->id}}">Zdieľať</button>
                                    @endauth
                                </div>

                                @auth
                                    @can('delete', $todo)
                                    {{--Trash icon for deleting items--}}
                                    <form method="POST" action="{{route('todos.destroy', $todo->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                        </button>
                                    </form>
                                    @endcan
                                @else
                                    {{--Trash icon for deleting items--}}
                                    <form method="POST" action="{{route('todos.destroy', $todo->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    @if(!empty($todos))
        @foreach($todos as $todo)
            <div class="modal fade" id="shareTodoModal{{$todo->id}}" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content" method="POST" action="{{route('todos.share', $todo->id)}}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Zdieľanie úlohy: {{$todo->title}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="h6">Vyberte používateľa s ktorým chcete úlohu zdieľať</div>
                            @foreach($users as $user)
                                <div class="d-flex my-1">
                                    <input type="radio" name="user" value="{{$user->id}}" id="{{$user->id}}">
                                    <label class="ms-2" for="{{$user->id}}">{{$user->name}}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Potvrdiť</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

@endsection
