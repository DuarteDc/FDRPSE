<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller {

    public function index() {
        $categories = Category::all();
        $this->responseJson(['categories' => $categories]);
    }
    
}