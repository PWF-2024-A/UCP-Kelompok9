<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Psy\Command\EditCommand;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::with('category')
            ->where('user_id', auth()->user()->id)
            ->orderBy('is_complete', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $todosCompleted = Todo::where('user_id', auth()->user()->id)
            ->where('is_complete', true)
            ->count();
        return view('todo.index', compact('todos', 'todosCompleted'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('todo.create', compact('categories'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'is_complete' => 'required',
        ]);

        $todo = new Todo();
        $todo->title = $request->title;
        $todo->category_id = $request->category_id;
        $todo->user_id = auth()->user()->id;
        $todo->is_complete = $request->is_complete == '1' ? true : false;
        $todo->save();

        return redirect()->route('todo.index')->with('success', 'Todo created successfully');
    }

    public function complete(Todo $todo)
    {
        $todo->is_complete = true;
        $todo->save();

        return redirect()->route('todo.index')->with('success', 'Todo marked as completed');
    }

    public function incomplete(Todo $todo)
    {
        $todo->is_complete = false;
        $todo->save();

        return redirect()->route('todo.index')->with('success', 'Todo marked as incomplete');
    }

    public function edit(Todo $todo)
    {
        $categories = Category::all();
        return view('todo.edit', compact('todo', 'categories'));
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $todo->update([
            'title' => ucfirst($request->title),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo updated successfully');
    }

    public function destroy(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->delete();
            return redirect()->route('todo.index')->with('success', 'Todo deleted successfully');
        } else {
            return redirect()->route('todo.index')->with('error', 'You are not authorized to delete this todo');
        }
    }

    public function destroyCompleted()
    {
        // get all todos for current user where is_completed is true
        $todosCompleted = Todo::where('user_id', auth()->user()->id)
            ->where('is_complete', true)
            ->get();
        foreach ($todosCompleted as $todo) {
            $todo->delete();
        }
        return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully');
    }
}
