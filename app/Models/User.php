<?php


namespace App\models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected  $table  = 'users';
    protected $fillable = ['name', 'last_name'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
