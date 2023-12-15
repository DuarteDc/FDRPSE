<?php

use App\Models\Question;
use App\Models\User;
use  Pecee\SimpleRouter\SimpleRouter as Route;

Route::get('/', function() {
    $user = Question::pluck('name', 'status');
    // var_dump($user);
    echo json_encode($user, JSON_PRETTY_PRINT);
    echo '<br> <br> <br>';
    //return json_encode(User::find(273)->with('administrativeUnit')->get(), JSON_PRETTY_PRINT);
});