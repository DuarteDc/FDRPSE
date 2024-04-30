<?php

namespace App\domain\guideUser;

use App\domain\guide\Guide;
use App\domain\survey\Survey;
use App\domain\user\User;
use Illuminate\Database\Eloquent\Relations\Pivot;

enum TypeQuestion: string
{
	case SECTION  = 'section';
	case QUESTION = 'question';
}
final class GuideUser extends Pivot
{
	public const INPROGRESS = false;
	public const FINISHED   = true;

	protected $table    = 'guide_survey_user';
	protected $fillable = ['guide_id', 'user_id', 'survey_id', 'answers', 'status', 'total'];
	protected $casts    = ['answers' => 'json'];

	public function guide()
	{
		return $this->belongsTo(Guide::class, 'guide_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function survey()
	{
		return $this->belongsTo(Survey::class, 'survey_id');
	}
}
