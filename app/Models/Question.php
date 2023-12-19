<?php 

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;

class Question  extends Model {

    protected $table = 'questions';
    protected $fillable = ['question', 'questionable_id', 'questionable_type'];

    public function questionable() {
        return $this->morphTo();
    } 

}