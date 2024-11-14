<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index()
    {
        try {
            $name = Auth::user()->name;
            $brands = Brand::join('categories', 'categories.id', '=', 'brands.category_id')
                            ->orderBy('brands.id', 'desc')
                            ->select('brands.*', 'categories.category_name as category_name')
                            ->paginate(5);

            return view('admin.brand.list', compact('brands', 'name'));
        } catch (Exception $e) {
            return redirect()->route('brand.list')->with('error', 'An error occurred while fetching brands: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $name = Auth::user()->name;
            $categories = Category::orderBy('id', 'desc')->get();
            return view('admin.brand.add', compact('categories', 'name'));
        } catch (Exception $e) {
            return redirect()->route('brand.list')->with('error', 'An error occurred while fetching categories: ' . $e->getMessage());
        }
    }

    public function store(BrandRequest $request)
    {
        try {
            $brand = new Brand();
            $brand->brand_name = $request->input('brand_name');
            $brand->category_id = $request->input('category_id');
            $brand->save();
            return redirect()->route('brand.list')->with('status', 'Brand added successfully');
        } catch (Exception $e) {
            return redirect()->route('brand.list')->with('error', 'An error occurred while adding the brand: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            return view('admin.brand.show', compact('brand'));
        } catch (Exception $e) {
            return redirect()->route('brand.list')->with('error', 'An error occurred while fetching the brand: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $name = Auth::user()->name;
            $brand = Brand::findOrFail($id);
            $categories = Category::orderBy('id', 'desc')->get();
            return view('admin.brand.edit', compact('brand', 'categories', 'name'));
        } catch (Exception $e) {
            return redirect()->route('brand.list')->with('error', 'An error occurred while fetching the brand for editing: ' . $e->getMessage());
        }
    }

    public function update(BrandRequest $request, $id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->brand_name = $request->input('brand_name');
            $brand->category_id = $request->input('category_id');
            $brand->save();

            return redirect()->route('brand.list')->with('status', 'Brand updated successfully');
        } catch (Exception $e) {
            return redirect()->route('brand.list')->with('error', 'An error occurred while updating the brand: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();

            return redirect()->route('brand.list')->with('status', 'Brand deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('brand.list')->with('error', 'An error occurred while deleting the brand: ' . $e->getMessage());
        }
    }
}
