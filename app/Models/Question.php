<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;

class Question  extends Model {

    protected $table = 'administrative_units';
    protected $fillable = ['question', 'questionable_id', 'questionable_type'];

    public function questionable() {
        return $this->morphTo();
    }

}