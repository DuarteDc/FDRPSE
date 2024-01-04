<?php

namespace App\Http\Controllers;

use App\Models\Dimension;

class DimensionController extends Controller
{

    public function index()
    {
        $dimensions = Dimension::all();
        $this->responseJson(['dimensions' => $dimensions]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:8|max:200',
        ], [
            'name:required' => 'El nombre es requerido',
            'name:min' => 'El nombre debe contener al menos 8 caracteres',
            'name:max' => 'El nombre debe contener máximo 200 caracteres',
        ]);

        $dimension = new Dimension([
            'name' => $this->post('name'),
        ]);

        $dimension->save();
        $this->responseJson(['message' => 'El dominio se creó correctamente']);
    }
}
