<?php

declare(strict_types=1);

namespace App\domain\qualifications;

use Illuminate\Database\Eloquent\Model;

final class Qualifications extends Model
{
	protected $table = 'qualifications';
	protected $fillable = [
		'despicable',
		'low',
		'middle',
		'high',
		'very_high',
		'qualificationable_id',
		'qualificationable_type',
	];

	public function qualificationable()
	{
		return $this->morphTo();
	}

	public function qualifications()
	{
		return $this->morphMany(self::class, 'qualificationable');
	}
}
