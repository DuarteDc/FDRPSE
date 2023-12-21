<?php

namespace App\Http\Controllers;

use App\Models\QualificationOption;

class QualificationOptionController extends Controller
{

    public function index()
    {
        $questions = QualificationOption::all();
        $this->responseJson($questions, 200);
    }

    public function save()
    {
        $questions = new QualificationOption([
            'name' =>               'Second Options',
            'always_op' =>          4,
            'almost_alwyas_op' =>   3,
            'sometimes_op' =>       2,
            'almost_never_op' =>    1,
            'never_op' =>           0,
        ]);

        $questions->save();

        $this->responseJson(['question' => $questions]);
    }
}
