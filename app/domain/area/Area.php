<?php

namespace App\domain\area;

use Illuminate\Database\Eloquent\Model;
use App\domain\user\User;

class Area extends Model
{
    protected $table = 'areas';
    protected $connection = 'user_db';

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
