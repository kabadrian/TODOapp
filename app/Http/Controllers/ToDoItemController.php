<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ToDoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = null;
        if(Auth::check()) {
            $user_id = Auth::id();
            if ($user_id) {
                $todos = ToDoItem::where('user_id', $user_id)->get();
            }
        }

        return view('to_do_items.index', ['todos' => $todos]);
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
    public function show(ToDoItem $toDoItem)
    {
        //
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
}
