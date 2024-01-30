<?php

namespace App\domain\dimension;

use Illuminate\Database\Eloquent\Model;
use App\domain\question\Question;

class Dimension extends Model
{

    protected $table = 'dimensions';
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
