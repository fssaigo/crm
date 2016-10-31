<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
     * 'groupId', 'name', 'email', 'mobile'
     * @return array
     */
    public function rules()
    {
        return [
            'groupId' => 'required',
            'name' => 'between:2,50',
            'password' => 'between:6,30',
            'email' => 'required|email',
            'mobile' => 'required|min:11|max:11',
        ];
    }

    public function messages()
    {
        return [
            'groupId.required' => '归属小组不能为空',
            'name.between' => '长度必须在2-20个以内',
            'password.between' => '密码长度必须在6-30个以内',
            'email.required' => 'Email不能为空',
            'email.email' => 'email格式不正确',
            'mobile.required' => '手机号码不能为空',
            'mobile.min' => '长度不正确',
        ];
    }
}
