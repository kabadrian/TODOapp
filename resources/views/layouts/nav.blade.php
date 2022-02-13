<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-md">
        <a class="navbar-brand" href="{{route('todos.index')}}">Todo app</a>

        <!-- If user is logged in display logout button, otherwise display login button-->
        @auth
            <form action="{{route('logout')}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light">Odhlásiť</button>
            </form>
        @else
            <div>
                <a href="{{route('register')}}" class="btn btn-light me-4">Registrácia</a>
                <a href="{{route('login')}}" class="btn btn-light">Prihlásiť</a>
            </div>
        @endauth
    </div>

</nav>
