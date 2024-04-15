<?php

declare(strict_types=1);

namespace App\domain\qualificationQuestion;

use Illuminate\Database\Eloquent\Model;

final class QualificationQuestion extends Model
{
	protected $table = 'qualifications_question';
	protected $fillable = ['question_id', 'qualificationable_id', 'qualificationable_type'];

	public const CATEGORY = 'category';
	public const DOMIAN = 'domain';

	public function qualificationable()
	{
		return $this->morphTo();
	}

	public function qualificationQuestions()
	{
		return $this->morphMany(self::class, 'qualificationable');
	}
}
