<?php


namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected  $table  = 'users';
    //protected $fillable = ['name', 'last_name'];


    // protected $connection = 'pgsql';


    public function administrativeUnit()  {
        return $this->belongsTo(Question::class);
    }


}
