<?php

namespace Armincms\SanctumLogin\Http\Requests;
 

class MobileLoginRequest extends LoginRequest
{   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => ['requried', function($value, $attribute, $fail) {
                $fail('mobile');
            }]
        ];
    }
}
