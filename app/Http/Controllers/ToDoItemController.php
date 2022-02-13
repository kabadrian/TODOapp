<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ToDoItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ToDoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $todos = null;
        if(Auth::check()) {
            $user_id = Auth::id();
            $user = User::find($user_id);
//           Get todos from database
            if ($user_id) {
                $mine = $request->get('mine');
                $shared = $request->get('shared');

//              If shared option is only checked, return shared todos
                if($shared && !$mine){
                    $todos = $user->sharedToDoItems;
                }
//              If mine option is only checked, return only mine todos
                elseif(!$shared && $mine){
                    $todos = ToDoItem::where('user_id', $user_id)->get();
                }
//              Otherwise, return both, mine and shared
                else{
                    $shared_todos = $user->sharedToDoItems;
                    $mine_todos = ToDoItem::where('user_id', $user_id)->get();
                    $todos = $mine_todos->merge($shared_todos);
                }
            }
        }
//      User is not logged in, get todos by sessionID
        else{
            $todos = ToDoItem::where('session_id', 'like', Session::getId())->get();
        }

        $category_id = $request->get('category');

//      Category was selected, filter todos by category
        if($category_id){
            $todos = $todos->where('category_id', $category_id);
        }

//      Return only completed todos
        if($request->get('completed')){
            $todos = $todos->whereNotNull('completed_at');
        }


        $categories = Category::all();
        $users = User::where('id', '!=', Auth::id())->get();

        return view('to_do_items.index', ['todos' => $todos, 'categories' => $categories, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('to_do_items.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required|min:2',
           'description' => ' required'
        ]);

        $title = $request->get('title');
        $description = $request->get('description');
        $categoryID = $request->get('category');

        $todo = new ToDoItem([
            'title' => $title,
            'description' => $description,
            'category_id' => $categoryID
        ]);

        if(Auth::check()){
            $todo->user_id = Auth::id();
        }
        else{
            $todo->session_id = Session::getId();
        }


        $todo->save();

        return redirect()->route('todos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToDoItem  $toDoItem
     * @return \Illuminate\Http\Response
     */
    public function show($toDoID)
    {
        $toDoItem = ToDoItem::find($toDoID);
        return view('to_do_items.show', ['todo'=>$toDoItem]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ToDoItem  $toDoItem
     * @return \Illuminate\Http\Response
     */
    public function edit($toDoItemID)
    {
        $todo = ToDoItem::find($toDoItemID);
        $categories = Category::all();
        return view('to_do_items.edit', ['todo' => $todo, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ToDoItem  $toDoItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $toDoItemID)
    {
        $request->validate([
            'title' => 'required|min:2',
            'description' => ' required'
        ]);

        $todo = ToDoItem::find($toDoItemID);

        $todo->title = $request->get('title');
        $todo->description = $request->get('description');
        $todo->category_id = $request->get('category');

        $todo->save();

        return redirect()->route('todos.show', $toDoItemID);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToDoItem  $toDoItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToDoItem $toDoItem)
    {
        //
    }

    public function completed($todoID){
        $todo = ToDoItem::find($todoID);
//      If task was not yet completed set current time as completed_at
        if(!$todo->completed_at) {
            $todo->completed_at = now();
        }
//
        else{
            $todo->completed_at = null;
        }
        $todo->save();

        return redirect()->route('todos.index');
    }

    public function share(Request $request, $toDoID){
        $todo = ToDoItem::find($toDoID);

        $user_id = $request->get('user');

        $todo->sharedUsers()->attach($user_id);

        return redirect()->route('todos.index');
    }
}
