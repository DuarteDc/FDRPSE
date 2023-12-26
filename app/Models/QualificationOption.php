<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class QualificationOption extends Model
{

    protected $table = 'qualification_options';
    protected $fillable = ['name', 'always_op', 'almost_alwyas_op', 'sometimes_op', 'almost_never_op', 'never_op'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
