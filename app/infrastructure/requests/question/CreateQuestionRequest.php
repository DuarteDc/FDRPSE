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
            'section_id' => 'required|numeric',
            'dimension_id' => 'numeric',
            'qualification_id' => 'numeric',
            'type' => 'required'
        ];
    }

    public static function messages(): array
    {
        return [];
    }
    
}
