<?php

namespace App\Http\Controllers;

use App\Models\Domain;

class DomainController extends Controller
{

    public function index()
    {
        $domains = Domain::all();
        $this->responseJson(['domains' => $domains]);
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

        $domain = new Domain([
            'name' => $this->post('name'),
        ]);

        $domain->save();
        $this->responseJson(['message' => 'El dominio se creó correctamente']);
    }
}
