<?php

namespace App\infrastructure\repositories\guideSurvey;

use App\domain\guideSurvey\GuideStatus;
use App\domain\guideSurvey\GuideSurvey;
use App\domain\guideSurvey\GuideSurveyRepository as ContractRepository;
use App\domain\section\Section;
use App\infrastructure\repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

final class GuideSurveyRepository extends BaseRepository implements ContractRepository
{
	public function __construct(private readonly GuideSurvey $guideSurvey)
	{
		parent::__construct($guideSurvey);
	}

	public function findGuideInProgress(): ?GuideSurvey
	{
		return $this->guideSurvey::where('status', GuideStatus::INPROGRESS)
			->orderBy('id', 'asc')
			->first();
	}

	public function findQuestionInsideGuide(GuideSurvey $guideSurvey, string $questionId): ?Section
	{
		$guide = $guideSurvey->guides()
			->where('id', $guideSurvey->guide_id)
			->first();
			
		return $guide->sections()->where('id', $questionId)->first();
	}

	public function finalizedGuideSurvey(string $surveyId, string $guideId): ?GuideSurvey
	{
		$guideSurvey = $guideSurvey = $this->guideSurvey->where('survey_id', $surveyId)
			->where('guide_id', $guideId)->first();

		$guideSurvey->status = GuideStatus::FINISHED;
		$guideSurvey->save();

		return $guideSurvey;
	}

	public function startNextGuide(): ?GuideSurvey
	{
		$guide = $this->findGuideInProgress();
		if (!$guide) {
			return null;
		}
		$guide->status = GuideStatus::INPROGRESS;
		$guide->save();
		return $guide;
	}

	public function findByGuideSurvey(string $surveyId, string $guideId): ?GuideSurvey
	{
		return $this->guideSurvey::where('survey_id', $surveyId)
			->where('guide_id', $guideId)
			->first();
	}

	public function startGuideAndPauseOtherGuides(GuideSurvey $guideSurvey): array
	{
		$guides = $this->guideSurvey::where('survey_id', $guideSurvey->survey_id)
			->orderBy('id', 'asc')
			->get();

		$guides->map(function ($guide) use ($guideSurvey) {
			if ($guide->id == $guideSurvey->id) {
				$guide->status = GuideStatus::INPROGRESS;
				$guide->save();
				return $guide;
			}

			return $guide;
		});

		return $this->guideSurvey::where('survey_id', $guideSurvey->survey_id)
			->orderBy('id', 'asc')
			->get()
			->toArray();
	}

	public function existInProgressGuide(string $surveyId): int
	{
		return $this->guideSurvey::where('survey_id', $surveyId)
			->where('status', GuideStatus::INPROGRESS->value)
			->count();
	}

	public function findAvailableGuides(string $surveyId, string $guideId): ?GuideSurvey
	{
		return $this->guideSurvey::where('survey_id', $surveyId)
			->where('status', GuideStatus::INPROGRESS->value)
			->where('guide_id', '<>', $guideId)
			->orderBy('id', 'asc')
			->first();
	}

	public function findSurveyWithAvailableGuides(string $surveyId): Collection
	{
		return $this->guideSurvey::where('survey_id', $surveyId)
			->where('status', GuideStatus::INPROGRESS->value)
			->orderBy('id', 'asc')
			->get();
	}

}
