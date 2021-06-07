<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'email' =>'required|email',
            'password' => 'required|min:8',
        ];
    }
    public function messages()
    {
        return [
            'email.email'       => __('Email không đúng định dạng'),
            'email.required'    => __('Bạn chưa nhập Email.'),
            'password.required' => __('Mật khẩu là trường bắt buộc'),
            'password.min'      => __('Mật khẩu phải hơn 8 ký tự.'),
        ];
    }
}
