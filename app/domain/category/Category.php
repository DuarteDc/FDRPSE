<?php


namespace App\domain\category;

use Illuminate\Database\Eloquent\Model;

use App\domain\question\Question;
use App\domain\qualifications\Qualifications;

class Category extends Model
{

    protected $table = 'categories';
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function qualifications()
    {
        return $this->morphMany(Qualifications::class, 'qualificationable');
    }
}
