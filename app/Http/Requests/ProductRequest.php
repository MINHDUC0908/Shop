<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $productId = $this->route('id'); // If updating, get the product id from the route

        return [
            'product_name' => [
                'required',
                'string',
                'max:255',
                'unique:products,product_name,' . $productId,
            ],
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'Tên sản phẩm là bắt buộc.',
            'product_name.string' => 'Tên sản phẩm phải là chuỗi văn bản.',
            'product_name.max' => 'Tên sản phẩm không được dài quá 255 ký tự.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá sản phẩm phải là số.',
            'description.required' => 'Mô tả của sản phẩm không được để trống.',
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
            'brand_id.required' => 'Thương hiệu sản phẩm là bắt buộc.',
            'brand_id.exists' => 'Thương hiệu sản phẩm không tồn tại.',
        ];
    }
}
