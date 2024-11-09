<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Allow all users to submit this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $brandId = $this->route('id'); // Get brand ID if available (for update)
        
        $rules = [
            'brand_name' => 'required|unique:brands,brand_name,' . ($brandId ?: 'NULL') . ',id',
            'category_id' => 'required|exists:categories,id',
        ];

        return $rules;
    }

    /**
     * Get the validation messages.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'exists' => ':attribute không hợp lệ',
            'unique' => ':attribute đã tồn tại',
        ];
    }

    /**
     * Get custom attribute names.
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'brand_name' => 'Tên thương hiệu',
            'category_id' => 'Danh mục',
        ];
    }
}
