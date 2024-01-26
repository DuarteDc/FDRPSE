<?php


namespace App\domain\category;

use App\domain\question\Question;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->morphMany(Question::class, 'questionable');
    }
}
