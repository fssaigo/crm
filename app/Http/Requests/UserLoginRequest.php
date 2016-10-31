<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'email' => 'required',
            'password' => 'required|min:6|max:15',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => '用户名不能位空',
            'password.required' => '密码不能位空',
            'password.min' => '密码必须再6-15个字符以内',
        ];
    }

}
