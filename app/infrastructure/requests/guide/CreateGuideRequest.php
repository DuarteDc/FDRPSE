<?php

namespace App\infrastructure\requests\guide;

use App\kernel\request\Request;

class CreateGuideRequest extends Request
{
    public static function rules(): array
    {
        return [
            'name' => 'required|min:8|max:200',
            'gradable' => 'required|boolean',
        ];
    }

    public static function messages(): array
    {
        return [
            'name:required'         => 'El nombre del cuestionario es requerido',
            'name:min'              => 'El nombre debe contener al menos 8 caracteres',
            'name:max'              => 'El nombre debe contener máximo 200 caracteres',
            'gradable:required'     => 'Es necesario establecer si el cuestionario requiere calificaciones',
            'gradable:boolean'      => 'Por favor establece una opcion valida para el cuestionario'
        ];
    }
}
