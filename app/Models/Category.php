<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;


class Category extends Model
{

    protected $table = 'categories';
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->morphMany(Question::class, 'questionable');
    }
}
