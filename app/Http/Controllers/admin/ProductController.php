<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = Auth::user()->name;
        $products = Product::join('categories', 'categories.id', '=', 'products.category_id')
                    ->join('brands', 'brands.id', '=', 'products.brand_id')
                    ->orderBy('products.updated_at', 'DESC')
                    ->select('products.*', 'categories.category_name', 'brands.brand_name')
                    ->get();
        return view('admin.product.list', compact('products', 'name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::all();
        $brands = Brand::all();
        $name = Auth::user()->name;
        return view('admin.product.create', compact('categories', 'brands', 'name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $product = new Product();
            $product->product_name = $request->input('product_name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->outstanding = $request->input('outstanding');
            if ($request->hasFile('images')) {
                $image = $request->file('images');
                $imageName = time() . ' - ' . $image->getClientOriginalName();
                $image->move(public_path('imgProduct'), $imageName);
                $product->images = $imageName;
            } else {
                return back()->with('error', 'Ảnh sản phẩm là bắt buộc.');
            }
            if ($request->hasFile('description_image')) {
                $addImages = [];
                foreach ($request->file('description_image') as $image) {
                    $imageName = time() . '-' . $image->getClientOriginalName();
                    $image->move(public_path('imgDescriptionProduct'), $imageName);
                    $addImages[] = $imageName;
                }
                $product->description_image = json_encode($addImages);
            }
            $product->category_id = $request->input('category_id');
            $product->brand_id = $request->input('brand_id');
            $product->save(); 

            return redirect()->route('product.list')->with('status', 'Sản phẩm đã được thêm thành công.');
        } catch (Exception $e) {
            return redirect()->route('product.create')->with('error', 'Có lỗi xảy ra khi thêm sản phẩm.');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $name = Auth::user()->name;
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('admin.product.edit', compact('product', 'categories', 'name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            if(!$product)
            {
                return response()->json([
                    'error' => 'Product not found',
                ], 404);
            }
            $product->product_name = $request->input('product_name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->outstanding = $request->input('outstanding');
            $product->category_id = $request->input('category_id');
            $product->brand_id = $request->input('brand_id');
            $product->save(); 
            if ($request->hasFile('images'))
            {
                if ($product->images)
                {
                    $imagePath = public_path('imgProduct/' . $product->images);
                    if (file_exists($imagePath))
                    {
                        unlink($imagePath);
                    }
                    $image = $request->file('images');
                    $imageName = time() . ' - ' . $image->getClientOriginalName();
                    $image->move(public_path('imgProduct'), $imageName);
                    $product->images = $imageName;
                }
            }
            if ($request->hasFile('description_image'))
            {
                if ($product->description_image)
                {
                    $description_images = json_decode($product->description_image);
                    foreach($description_images as $image)
                    {
                        $imagePath = public_path('imgDescriptionProduct/' . $image);
                        if(file_exists($imagePath))
                        {
                            unlink($imagePath);
                        }
                    }
                    $addImages = [];
                    foreach($request->file('description_image') as $image)
                    {
                        $imageName = time() . '_' . $image->getClientOriginalName();
                        $image->move(public_path('imgDescriptionProduct'),$imageName);
                        $addImages[] = $imageName;
                    }
                    $product->description_image = json_encode($addImages);
                }
            }
            $product->save();
            return redirect()->route('product.list')->with('status', 'Product updated successfully');
        } catch (Exception $e)
        {
            return redirect()->route('product.list')->with('error', 'An error occurred while updating the product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            if(!$product)
            {
                return response()->json([
                    'error' => 'Product not found',
                ], 404);
            } else {
                if ($product->images)
                {
                    $imagePath = public_path('imgProduct/' . $product->images);
                    if(file_exists($imagePath))
                    {
                        unlink($imagePath);
                    }
                }
                if ($product->description_image)
                {
                    $description_images = json_decode($product->description_image);
                    foreach($description_images as $image)
                    {
                        $imagePath = public_path('imgDescriptionProduct/' . $image);
                        if (file_exists($imagePath))
                        {
                            unlink($imagePath);
                        }
                    }
                }
                $product->delete();
                return redirect()->route('product.list')->with('status', 'Product deleted successfully');
            }
        } catch (Exception $e)
        {
            return redirect()->route('product.list')->with('error', 'An error occurred while deleting the product: ' . $e->getMessage());
        }
    }
    public function getBrandsByCategory(Request $request)
    {
        $brands = Brand::where('category_id', $request->category_id)->get();
        return response()->json($brands);
    }    
}
