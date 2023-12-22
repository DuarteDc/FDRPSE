<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\models\User;

class Survey extends Model
{

    protected $table = 'survey';
    protected $fillable = ['user_id', 'body',];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
