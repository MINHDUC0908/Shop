<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:index category|edit category|delete category| add category', [
    //         'only' => ['index', 'show']
    //     ]);
    //     $this->middleware('permission:add category', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:edit category', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete category', ['only' => ['destroy']]);
    // }
    public function index()
    {
        try {
            $name = Auth::user()->name;
            $categories = Category::orderBy('id', 'DESC')->get();
            return view('admin.category.list', compact('categories', 'name'));
        } catch (Exception $e) {
            return redirect()->route('category.list')->with('error', 'Failed to fetch categories.');
        }
    }

    public function create()
    {
        $name = Auth::user()->name;
        return view('admin.category.add', compact('name'));
    }

    public function store(CategoryRequest $request)
    {
        try {
            $category = new Category();
            $category->category_name = $request->input('category_name');
            $category->save();
            return redirect()->route('category.list')->with('status', 'Category added successfully.');
        } catch (Exception $e) {
            return redirect()->route('category.list')->with('error', 'Failed to add category.');
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('admin.category.show', compact('category'));
        } catch (Exception $e) {
            return redirect()->route('category.list')->with('error', 'Category not found.');
        }
    }

    public function edit($id)
    {
        try {
            $name = Auth::user()->name;
            $category = Category::findOrFail($id);
            return view('admin.category.edit', compact('category', 'name'));
        } catch (Exception $e) {
            return redirect()->route('category.list')->with('error', 'Category not found.');
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->category_name = $request->category_name;
            $category->save();
            return redirect()->route('category.list')->with('status', 'Category updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('category.list')->with('error', 'Failed to update category.');
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->route('category.list')->with('status', 'Category deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('category.list')->with('error', 'Failed to delete category.');
        }
    }
}
