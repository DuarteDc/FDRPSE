<?php

declare(strict_types=1);

namespace App\domain\domain;

use App\domain\qualificationQuestion\QualificationQuestion;
use App\domain\qualifications\Qualifications;

use App\domain\question\Question;
use Illuminate\Database\Eloquent\Model;

final class Domain extends Model
{
	protected $table     = 'domains';
	protected $fillable  = ['name'];
	protected $withCount = ['qualifications'];

	public function questions()
	{
		return $this->hasMany(Question::class);
	}

	public function qualifications()
	{
		return $this->morphMany(Qualifications::class, 'qualificationable');
	}

	public function qualification()
	{
		return $this->morphOne(Qualifications::class, 'qualificationable');
	}

	public function qualificationQuestion()
	{
		return $this->morphOne(QualificationQuestion::class, 'qualificationable');
	}


	public function qualificationsQuestion()
	{
		return $this->morphMany(QualificationQuestion::class, 'qualificationable');
	}
}
