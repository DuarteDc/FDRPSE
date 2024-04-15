<?php

declare(strict_types=1);

namespace App\domain\dimension;

use App\domain\question\Question;
use Illuminate\Database\Eloquent\Model;

final class Dimension extends Model
{
	protected $table = 'dimensions';
	protected $fillable = ['name'];

	public function questions()
	{
		return $this->hasMany(Question::class);
	}
}
