<?php


namespace App\Http\Requests\Question;

use App\Http\Interfaces\HttpRulesRequest;
use App\Http\Requests\Request;

class CreateQuestionRequest extends Request implements HttpRulesRequest
{

    public static function rules(): array
    {
        return [
            'question' => 'required|min:8|max:200',
            'category_id' => 'required',
            'qualification_id' => 'required',
        ];
    }

    public static function messages(): array
    {
        return [];
    }
}
