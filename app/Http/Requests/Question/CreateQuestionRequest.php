<?php


namespace App\Http\Requests\Question;

use App\Http\Interfaces\HttpRulesRequest;
use App\Http\Requests\Request;

class CreateQuestionRequest extends Request implements HttpRulesRequest
{

    public static function rules(): array
    {
        return [
            'name' => 'required|min:8|max:200',
            'category_id' => 'required|numeric',
            'qualification_id' => 'required|numeric',
            'section_id' => 'required|numeric',
        ];
    }

    public static function messages(): array
    {
        return [];
    }
    
}
