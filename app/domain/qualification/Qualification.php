<?php 

namespace App\domain\qualification;

use App\domain\question\Question;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model {

    protected $table = 'qualification_options';
    protected $fillable = ['name', 'always_op', 'almost_alwyas_op', 'sometimes_op', 'almost_never_op', 'never_op'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}