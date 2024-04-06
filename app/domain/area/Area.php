<?php

namespace App\domain\area;

use Illuminate\Database\Eloquent\Model;
use App\domain\user\User;

class Area extends Model
{
    protected $table = 'areas';
    protected $connection = 'user_db';

    protected $withCount = ['users'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_area');
    }

    public function subdirections()
    {
        return $this->hasMany(Area::class, 'area_padre');
    }

    public function departments()
    {
        return $this->hasMany(Area::class, 'area_padre');
    }

    public function getMainArea(string $areaId)
    {
        return $this->where('area_padre', $areaId)->get();
    }
}
