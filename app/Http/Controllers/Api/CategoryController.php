<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Exception;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::orderBy('id', 'DESC')->get();

            return response()->json([
                'message' => 'Danh mục sản phẩm',
                'data' => $categories,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi lấy danh mục sản phẩm.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Không tìm thấy danh mục với ID: ' . $id,
                    'data' => null,
                ], 404);
            }

            return response()->json([
                'message' => 'Danh mục ' . $id,
                'data' => $category,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi lấy danh mục.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
