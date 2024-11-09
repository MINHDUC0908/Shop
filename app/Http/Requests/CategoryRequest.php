<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $categoryId = $this->route('id'); // Lấy id từ route, nếu có

        return [
            'category_name' => [
                'required',
                'unique:categories,category_name,' . $categoryId,
            ],
        ];
    }

    /**
     * Các thông báo lỗi tuỳ chỉnh.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã tồn tại',
        ];
    }

    /**
     * Đặt tên trường để hiển thị trong thông báo lỗi.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'category_name' => 'Tên danh mục',
        ];
    }
}
