<?php 


namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Question;


class Category extends Model {

    protected $table = 'categories';


    public function questions() {
        return $this->hasMany(Question::class);
    }


}