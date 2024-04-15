<?php

declare(strict_types=1);

namespace App\domain\area;

use App\domain\user\User;
use Illuminate\Database\Eloquent\Model;

final class Area extends Model
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
		return $this->hasMany(self::class, 'area_padre');
	}

	public function departments()
	{
		return $this->hasMany(self::class, 'area_padre');
	}

	public function father()
	{
		return $this->belongsTo(self::class, 'area_padre');
	}
}
