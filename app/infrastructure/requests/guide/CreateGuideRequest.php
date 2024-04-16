<?php

declare(strict_types=1);

namespace App\infrastructure\requests\guide;

use App\kernel\request\Request;

final class CreateGuideRequest extends Request
{
	public static function rules(): array
	{
		return [
			'name'       => 'required|min:8|max:200',
			'gradable'   => 'required',
			'sections'   => 'required|array',
			'despicable' => 'numeric|min:' . (self::post('gradable') === 'gradable' ? '1' : '0'),
			'low'        => 'numeric|min:' . (self::post('gradable') === 'gradable' ? (int) self::post('despicable') + 1 : '0'),
			'middle'     => 'numeric|min:' . (self::post('gradable') === 'gradable' ? (int) self::post('low') + 1 : '0'),
			'high'       => 'numeric|min:' . (self::post('gradable') === 'gradable' ? (int) self::post('middle') + 1 : '0'),
			'very_high'  => 'numeric|min:' . (self::post('gradable') === 'gradable' ? (int) self::post('high') + 1 : '0'),
		];
	}

	public static function messages(): array
	{
		return [
			'name:required'      => 'El nombre del cuestionario es requerido',
			'name:min'           => 'El nombre debe contener al menos 8 caracteres',
			'name:max'           => 'El nombre debe contener máximo 200 caracteres',
			'gradable:required'  => 'Es necesario establecer si el cuestionario requiere calificaciones',
			'sections:required'  => 'Para crear una guia es necesario que contenga secciones',
			'sections:array'     => 'Las secciones no son validas',
			'despicable:numeric' => 'La calificación minima debe ser un número',
			'despicable:min'     => 'La calificación minima debe ser al menos de valor 1',
			'low:numeric'        => 'La calificación baja debe ser un número',
			'low:min'            => 'La calificación baja debe ser al menos de valor ' . (int) self::post('despicable') + 1,
			'middle:numeric'     => 'La calificación media debe ser un número',
			'middle:min'         => 'La calificación media debe ser al menos de valor ' . (int) self::post('low') + 1,
			'high:numeric'       => 'La calificación alta debe ser un número',
			'high:min'           => 'La calificación alta debe ser al menos de valor ' . (int) self::post('middle') + 1,
			'very_high:numeric'  => 'La calificación más alta debe ser un número',
			'very_high:min'      => 'La calificación más alta debe ser al menos de valor ' . (int) self::post('high') + 1,
		];
	}
}
