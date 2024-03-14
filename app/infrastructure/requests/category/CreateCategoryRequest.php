<?php

namespace App\infrastructure\requests\category;

use App\kernel\request\Request;
use App\kernel\request\HttpRulesRequest;

class CreateCategoryRequest extends Request implements HttpRulesRequest
{
    public static function rules(): array
    {
        return [
            'name'       => 'required|min:8|max:200',
            'despicable' => "required|numeric|min:1",
            'low'        => "required|numeric|min:" . (int) static::post('despicable') + 1,
            'middle'     => "required|numeric|min:" . (int) static::post('low') + 1,
            'high'       => "required|numeric|min:" . (int) static::post('middle') + 1,
            'very_high' => "required|numeric|min:" . (int) static::post('high') + 1,
        ];
    }

    public static function messages(): array
    {
        return [
            'name:required'         => 'El nombre del dominio es requerido',
            'name:min'              => 'El nombre debe contener al menos 8 caracteres',
            'name:max'              => 'El nombre debe contener máximo 200 caracteres',
            'despicable:required'   => 'La calificación minima es requerida',
            'despicable:numeric'    => 'La calificación minima debe ser un número',
            'despicable:min'        => 'La calificación minima debe ser al menos de valor 1',
            'low:required'          => 'La calificación baja es requerida',
            'low:numeric'           => 'La calificación baja debe ser un número',
            'low:min'               => 'La calificación baja debe ser al menos de valor '.      (int) static::post('despicable') + 1,
            'middle:required'       => 'La calificación media es requerida',
            'middle:numeric'        => 'La calificación media debe ser un número',
            'middle:min'            => 'La calificación media debe ser al menos de valor '.     (int) static::post('low') + 1,
            'high:required'         => 'La calificación alta es requerida',
            'high:numeric'          => 'La calificación alta debe ser un número',
            'high:min'              => 'La calificación alta debe ser al menos de valor '.      (int) static::post('middle') + 1,
            'very_high:required'   => 'La calificación más alta es requerida',
            'very_high:numeric'    => 'La calificación más alta debe ser un número',
            'very_high:min'        => 'La calificación más alta debe ser al menos de valor '.  (int) static::post('high') + 1,
        ];
    }
}
