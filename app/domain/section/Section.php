<?php

declare(strict_types=1);

namespace App\domain\section;

use App\domain\guide\Guide;
use App\domain\question\Question;
use Illuminate\Database\Eloquent\Model;

final class Section extends Model
{
	public const GRADABLE    = 'gradable';
	public const NONGRADABLE = 'nongradable';

	protected $table     = 'sections';
	protected $fillable  = ['name', 'binary', 'question', 'can_finish_guide', 'type', 'guide_id', 'status'];
	protected $withCount = ['questions'];

	public function questions()
	{
		return $this->hasMany(Question::class);
	}

	public function guide()
	{
		return $this->belongsTo(Guide::class);
	}
}
