<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $id = $this->route('user')->id;
        return [
            "name" => "string",
            "lastname" => "string",
            "phone" => "string|unique:users,phone," . $id,
            "birthday" => "date",
            "email" => "email|string|unique:users,email," . $id,
            "password" => "min:8|confirmed",
        ];
    }
}
