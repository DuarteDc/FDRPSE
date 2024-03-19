<?php

namespace App\domain\section;

use App\domain\guide\Guide;
use App\domain\question\Question;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    const GRADABLE  = 'gradable';
    const NONGRADABLE  = 'nongradable';

    protected $table = 'sections';
    protected $fillable = ['name', 'binary', 'question', 'can_finish_guide', 'type'];
    protected $withCount = ['questions'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

}
