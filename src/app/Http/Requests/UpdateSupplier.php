<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplier extends FormRequest
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
            'name' => 'required_without_all:the others|required|min:3|max:255',
            'email' => 'required_without_all:the others|required|email',
            'monthlyPayment' => 'required_without_all:the others|required|numeric|min:0',
        ];
    }
}
