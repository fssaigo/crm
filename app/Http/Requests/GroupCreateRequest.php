<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:50',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '品牌名称不能为空',
            'name.min' => '品牌名称长度至少在2个字符以内',
        ];
    }

}
