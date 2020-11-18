<?php

namespace Armincms\SanctumLogin\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;
use Armincms\SanctumLogin\Models\User;

class SimpleLoginRequest extends FormRequest
{   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }
}
