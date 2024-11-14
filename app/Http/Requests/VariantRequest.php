<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VariantRequest extends FormRequest
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
        return [
            'product_id' => 'required|exists:products,id',
            'parameter' => 'required', 
            'colors' => 'required|string',
            'price' => 'required|numeric|min:0', 
            'quantity' => 'required|integer|min:0',
            'attribute' => [
                'max:255',
                Rule::unique('variants')->where(function ($query) {
                    return $query->where('product_id', $this->product_id);
                })->ignore($this->variant),
            ],
        ];
    }
    public function messages()
    {
        return [
            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_id.exists' => 'Sản phẩm đã chọn không hợp lệ.',
            'parameter.required' => 'Tham số là bắt buộc.',
            'parameter.string' => 'Tham số phải là chuỗi văn bản.',
            'parameter.max' => 'Tham số không được vượt quá 255 ký tự.',
            'colors.string' => 'Mỗi màu phải là chuỗi.',
            'colors.required' => 'Màu sắc không được để trống.',
            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là một số hợp lệ.',
            'price.min' => 'Giá không thể nhỏ hơn 0.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng không thể nhỏ hơn 0.',
            'attribute.unique' => 'Kết hợp sản phẩm và thuộc tính này đã tồn tại.',
        ];
    }
}
