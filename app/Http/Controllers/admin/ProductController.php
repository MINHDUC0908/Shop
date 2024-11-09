<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
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
        $products = Product::join('categories', 'categories.id', '=', 'products.category_id')
                    ->join('brands', 'brands.id', '=', 'products.brand_id')
                    ->orderBy('products.updated_at', 'DESC')
                    ->select('products.*', 'categories.category_name', 'brands.brand_name')
                    ->get();
        return view('admin.product.list', compact('products'));
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
        return view('admin.product.create', compact('categories', 'brands'));
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

            // Handle product image
            if ($request->hasFile('images')) {
                $image = $request->file('images');
                $imageName = time() . ' - ' . $image->getClientOriginalName();
                $image->move(public_path('imgProduct'), $imageName);
                $product->images = $imageName;
            } else {
                return back()->with('error', 'Ảnh sản phẩm là bắt buộc.');
            }

            // Handle description images
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
            $product->save(); // Save the product

            return redirect()->route('product.list')->with('success', 'Sản phẩm đã được thêm thành công.');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getBrandsByCategory(Request $request)
    {
        $brands = Brand::where('category_id', $request->category_id)->get();
        return response()->json($brands);
    }    
}
