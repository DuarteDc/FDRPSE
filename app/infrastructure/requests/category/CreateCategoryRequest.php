<?php

namespace App\infrastructure\requests\category;

use App\kernel\request\HttpRulesRequest;
use App\kernel\request\Request;

final class CreateCategoryRequest extends Request implements HttpRulesRequest
{
	public static function rules(): array
	{
		return [
			'name'                        => 'required|min:8|max:200',
			'qualifications'              => 'array',
			'qualifications.*.despicable' => 'required|numeric',
			'qualifications.*.low'        => 'required|numeric',
			'qualifications.*.middle'     => 'required|numeric',
			'qualifications.*.high'       => 'required|numeric',
			'qualifications.*.very_high'  => 'required|numeric',
			// " |min:1",
			// " |min:" . "1000",
			// " |min:" . (int) static::post('low') + 1,
			// " |min:" . (int) static::post('middle') + 1,
			// " |min:" . (int) static::post('high') + 1,
		];
	}

	public static function messages(): array
	{
		return [
			'name:required'                        => 'El nombre del dominio es requerido',
			'name:min'                             => 'El nombre debe contener al menos 8 caracteres',
			'name:max'                             => 'El nombre debe contener máximo 200 caracteres',
			'qualifications:required'              => 'La calificaciones de la categoría son requeridas',
			'qualifications:array'                 => 'La calificaciones de la categoría no son validas',
			'qualifications.*.despicable:required' => 'La calificación minima es requerida',
			'qualifications.*.despicable:numeric'  => 'La calificación minima debe ser un número',
			'qualifications.*.despicable:min'      => 'La calificación minima debe ser al menos de valor 1',
			'qualifications.*.low:required'        => 'La calificación baja es requerida',
			'qualifications.*.low:numeric'         => 'La calificación baja debe ser un número',

			// 'qualifications.*.low:min'                  => 'La calificación baja debe ser al menos de valor :attribute',

			'qualifications.*.middle:required' => 'La calificación media es requerida',
			'qualifications.*.middle:numeric'  => 'La calificación media debe ser un número',
			// 'qualifications.*.middle:min'               => 'La calificación media debe ser al menos de valor ' .     (int) static::post('low') + 1,
			'qualifications.*.high:required' => 'La calificación alta es requerida',
			'qualifications.*.high:numeric'  => 'La calificación alta debe ser un número',
			// 'qualifications.*.high:min'                 => 'La calificación alta debe ser al menos de valor :attribute' .      (int) static::post('middle') + 1,
			'qualifications.*.very_high:required' => 'La calificación más alta es requerida',
			'qualifications.*.very_high:numeric'  => 'La calificación más alta debe ser un número',
			// 'qualifications.*.very_high:min'            => 'La calificación más alta debe ser al menos de valor ' .  (int) static::post('high') + 1,
		];
	}
}
