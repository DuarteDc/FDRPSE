<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $this->responseJson(['categories' => $categories]);
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

        $section = new Category([
            'name' => $this->post('name'),
        ]);

        $section->save();
        $this->responseJson(['message' => 'La sección se creó correctamente']);
    }
}
