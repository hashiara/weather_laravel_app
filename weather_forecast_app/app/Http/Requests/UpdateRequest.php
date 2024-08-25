<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $today = date('Y-m-d');
        
        return [
            'prefecture' => ['required_with:city', 'integer', 'nullable'],
            'city' => ['integer', 'nullable'],
            'birth' => ['date', 'before_or_equal:'.$today, 'nullable'],
            'area_code' => ['required_with:rail_order', 'integer', 'nullable'],
            'rail_order' => ['required_with:area_code', 'integer', 'nullable'],
        ];
    }

    public function attributes()
    {
        return [
            'prefecture' => '都道府県',
            'city' => '市区町村',
            'birth' => '生年月日',
            'area_code' => '地域',
            'rail_order' => '路線',
        ];
    }
}
