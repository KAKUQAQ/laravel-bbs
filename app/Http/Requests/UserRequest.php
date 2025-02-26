<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|between:3,25|regex:/^[a-zA-Z0-9\-\_]+$/|unique:users,name,'.Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
            'avatar' => 'image|mimes:jpeg,jpg,png,gif|dimensions:min_width=208,min_height=208',
        ];
    }
    public function messages(): array
    {
        return [
            'name.unique' => 'this name is already taken',
            'name.between' => 'name must be between 3 and 25 characters',
            'name.regex' => 'name must only contain letters, numbers, dashes and underscores',
            'name.required' => 'name is required',
            'avatar.mimes' => 'avatar must be a jpeg, jpg, png, gif image',
            'avatar.dimensions' => 'avatar must be at least 208x208',
        ];
    }
}
