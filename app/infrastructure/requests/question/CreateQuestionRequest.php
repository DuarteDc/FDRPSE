<?php


namespace App\infrastructure\requests\question;

use App\kernel\request\Request;
use App\kernel\request\HttpRulesRequest;

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
