<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    protected $table = 'sections';
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
