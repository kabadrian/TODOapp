<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ToDoItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            if ($user_id) {
                $category_id = $request->get('category');
                $origin = $request->get('origin');

                if($category_id) {
                    $todos = ToDoItem::where('category_id', $category_id)->get();
                }
                elseif($origin){
                    if($origin == "mine"){
                        $todos = ToDoItem::where('user_id', Auth::id())->get();
                    }
                    elseif($origin == "shared"){
                        $todos = $user->sharedToDoItems;
                    }
                }
                else {
                    $mine_todos = ToDoItem::where('user_id', $user_id)->get();
                    $shared_todos = $user->sharedToDoItems;
                    $todos = $mine_todos->merge($shared_todos);
                }
            }
        }
        else{
//            todo session storage
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('description');
        $categoryID = $request->get('category');
        $userID = Auth::id();

        $todo = new ToDoItem([
            'title' => $title,
            'description' => $description,
            'category_id' => $categoryID,
            'user_id' => $userID
        ]);

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
    public function edit(ToDoItem $toDoItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ToDoItem  $toDoItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToDoItem $toDoItem)
    {
        //
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
