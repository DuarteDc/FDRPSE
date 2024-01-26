<?php

namespace App\Http\Controllers;

use App\Models\Section;

class SectionController extends Controller
{

    public function index()
    {
        $sections = Section::all();

        $this->responseJson(['sections' => $sections]);
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

        $section = new Section([
            'name' => $this->post('name'),
        ]);

        $section->save();
        $this->responseJson(['message' => 'La sección se creó correctamente', 'section' => $section]);
    }
}
