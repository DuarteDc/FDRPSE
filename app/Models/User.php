<?php


namespace App\models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected  $table  = 'users';
    protected $fillable = ['name', 'last_name'];

    public function questions()
    {
        return $this->belongsTo(Question::class);
    }

    public function getUppercaseName()
    {
        return strtoupper($this->name);
    }

    public function hashedPassword(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public function verifyPassword(string $password, string $hash) {
        return password_verify($password, $hash);
    }

}
