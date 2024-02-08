<?php

namespace App\domain\section;

use App\domain\question\Question;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    protected $table = 'sections';
    protected $fillable = ['name', 'binary', 'question'];
    protected $withCount = ['questions'];
        

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
