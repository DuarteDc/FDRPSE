<?php

declare(strict_types=1);

namespace App\domain\guide;

use App\domain\guideSurvey\GuideSurvey;
use App\domain\guideUser\GuideUser;
use App\domain\qualifications\Qualifications;
use App\domain\section\Section;
use App\domain\survey\Survey;
use App\domain\user\User;
use Illuminate\Database\Eloquent\Model;

final class Guide extends Model
{
	protected $fillable = ['name', 'status'];
	protected $table = 'guides';

	public const ACTIVE = 'active';
	public const DISABLE = 'disable';

	public function surveys()
	{
		return $this->belongsToMany(Survey::class)
			->using(GuideSurvey::class)
			->withPivot('qualification', 'status');
	}

	public function sections()
	{
		return $this->hasMany(Section::class);
	}

	public function qualification()
	{
		return $this->morphOne(Qualifications::class, 'qualificationable');
	}

	public function users()
	{
		return $this->belongsToMany(User::class)->using(GuideUser::class);
	}

	public function survey()
	{
		return $this->belongsToMany(Survey::class)
			->using(GuideSurvey::class)
			->withPivot('qualification');
	}
}
