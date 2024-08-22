<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $id = $this->request->get('id');
        if($id == ''){
            return [
                'p_name' => 'required|string|max:255',
                'p_code' => 'required|string|max:255|unique:product',
                'p_package'=> 'required',
                'p_quantity'=> 'required|numeric',
                'p_description'=> 'required',
            ];
        }else{
            return [
                'p_name' => 'required|string|max:255',
                'p_code' => 'required|string|max:255|unique:product,p_code,'.$id,
                'p_package'=> 'required',
                'p_quantity'=> 'required|numeric',
                'p_description'=> 'required',
            ];
        }
    }

    public function messages()
    {
        $messages = array(
            'p_name.required' => trans(
                'validation.custom.common_required',
                ["attribute" => "Product Name"]
            ),
            'p_name.max' => trans(
                'validation.custom.max.string',
                ["attribute" => "Product Name"]
            ),
            'p_name.string' => trans(
                'validation.string',
                ["attribute" => "Product Name"]
            ),
            'p_code.required' => trans(
                'validation.custom.common_required',
                ["attribute" => "Product Code"]
            ),
            'p_code.max' => trans(
                'validation.custom.max.string',
                ["attribute" => "Product Code"]
            ),
            'p_code.string' => trans(
                'validation.string',
                ["attribute" => "Product Code"]
            ),
            'p_code.unique' => trans(
                'validation.unique',
                ["attribute" => "Product Code"]
            ),
            'p_package.required' => trans(
                'validation.custom.common_required',
                ["attribute" => "Product Package"]
            ),
            'p_description.required' => trans(
                'validation.custom.common_required',
                ["attribute" => "Product Description"]
            ),
            'p_quantity.required' => trans(
                'validation.custom.common_required',
                ["attribute" => "Product Quantity"]
            ),
            'p_quantity.numeric' => trans(
                'validation.numeric',
                ["attribute" => "Product Quantity"]
            ),

        );
        return $messages;
    }
}
