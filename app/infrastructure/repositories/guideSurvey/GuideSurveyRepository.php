<?php

namespace App\infrastructure\repositories\guideSurvey;

use App\domain\guideSurvey\GuideStatus;
use App\domain\guideSurvey\GuideSurvey;
use App\domain\guideSurvey\GuideSurveyRepository as ContractRepository;
use App\domain\section\Section;
use App\infrastructure\repositories\BaseRepository;

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
}
