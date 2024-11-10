<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariantRequest;
use App\Models\Product;
use App\Models\Variant;
use Exception;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $variants = Variant::join('products', 'products.id', '=', 'variants.product_id')
                            ->select('variants.*', 'products.product_name as product_name')
                            ->orderBy('variants.id','DESC')
                            ->get();
        return view('admin.variant.list', compact('variants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $products = Product::orderBy('id', 'desc')->get();
            return view('admin.variant.add', compact('products'));
        } catch (Exception $e) {
            return redirect()->route('admin.variant.list')->with('error', 'An error occurred while fetching products: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VariantRequest $request)
    {
        try {
            $variant = new Variant();
            $variant->product_id = $request->input('product_id');
            $variant->parameter = $request->input('parameter');
            $variant->attribute = $request->input('attribute');
            $variant->price = $request->input('price');
            $colors = explode(',', $request->input('colors'));
            $colors = array_map('trim', $colors); 
            $variant->colors = json_encode($colors); 
            $variant->discount_price = $request->input('discount_price');
            $variant->quantity = $request->input('quantity');
            if ($request->input('quantity') > 0) {
                $variant->status = 'available';
            } else {
                $variant->status = 'out_of_stock';
            }
            $variant->save();
            return redirect()->route('variants.index')->with('status', 'Variant added successfully');
        } catch (Exception $e) {
            return redirect()->route('variants.index')->with('error', 'An error occurred while adding the variant: ' . $e->getMessage());
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
        $variant = Variant::findOrFail($id);
        return view('admin.variant.show', compact('variant'));
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
}