<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSearchKey extends FormRequest
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
            'area' => 'max:50',
            'name' => 'max:50',
            'state' => 'max:50',
            'city' => 'max:50',
            'category' => 'max:50',
            'gender_for' => 'max:50'
        ];
    }
}
