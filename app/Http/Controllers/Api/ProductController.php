<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $product = Product::with(['variants', 'category', 'brand'])->get();
            return response()->json([
                'message' => 'Sản phẩm',
                'data' => $product,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Lỗi truy vấn cơ sở dữ liệu',
                'error' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
