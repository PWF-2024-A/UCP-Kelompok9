<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->title = $request->title;
        $category->user_id = auth()->user()->id;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        if (auth()->user()->id == $category->user_id) {
            return view('category.edit', compact('category'));
        } else {
            return redirect()->route('category.index')->with('error', 'You are not authorized to edit this category');
        }
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category->update([
            'title' => ucfirst($request->title),
        ]);
        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        if (auth()->user()->id == $category->user_id) {
            $category->delete();
            return redirect()->route('category.index')->with('success', 'Category deleted successfully');
        } else {
            return redirect()->route('category.index')->with('error', 'You are not authorized to delete this category');
        }
    }
}
