<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesStoreRequest extends FormRequest
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
            "name" => ["required", "string", "unique:categories,name"],
            "type" => ["required", "integer", "exists:category_types,no"],
            "main_category" => ["nullable", "integer", "exists:categories,no"],
            "link_url" => ["required", "string", "unique:categories,link_url"],
        ];
    }
}