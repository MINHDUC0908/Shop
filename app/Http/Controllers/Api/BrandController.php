<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        try {
            $brands = Brand::orderBy('id', 'ASC')->get();
            return response()->json([
                'message' => 'Thương hiệu sản phẩm',
                'data' => $brands,
            ], 200);
        } catch (Exception $e)
        {
            return response()->json([
                'message' => 'An error occurred while retrieving the product catalog.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }     
    public function show($id)
    {
        try {
            $brands =Brand::find($id);

            if (!$brands) {
                return response()->json([
                    'message' => 'Không tìm thấy danh mục với ID: ' . $id,
                    'data' => null,
                ], 404);
            }

            return response()->json([
                'message' => 'Danh mục ' . $id,
                'data' => $brands,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi lấy danh mục.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
