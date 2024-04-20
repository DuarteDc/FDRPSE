<?php

namespace App\infrastructure\repositories\guide;

use App\domain\guide\Guide;
use App\domain\guide\GuideRepository as ContractsRepository;
use App\domain\guideSurvey\GuideStatus;
use App\infrastructure\repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

final class GuideRepository extends BaseRepository implements ContractsRepository
{
	public function __construct(private readonly Guide $guide)
	{
		parent::__construct($guide);
	}

	public function findByName(string $name): ?Guide
	{
		return $this->guide->where('name', $name)->first();
	}

	public function disableGuide(Guide $guide): Guide
	{
		$guide->update(['status' => false]);
		$guide->sections()->update(['status' => false]);
		$guide->sections()->each(function ($section) {
			$section->questions()->update(['status' => false]);
		});
		return $guide;
	}

	public function enableGuide(Guide $guide): Guide
	{
		$guide->update(['status' => true]);
		$guide->sections()->update(['status' => true]);
		$guide->sections()->each(function ($section) {
			$section->questions()->update(['status' => true]);
		});
		return $guide;
	}

	public function createAndSetQualification(object $body): Guide
	{
		$guide = new $this->guide(['name' => $body->name, 'gradable' => $body->gradable === 'gradable' ? true : false]);
		$guide->save();
		return $this->setGuideQualification($guide, $body);
	}

	public function setGuideQualification(Guide $guide, object $body): Guide
	{
		$guide->qualification()->create([
			'despicable' => $body->despicable,
			'low'        => $body->low,
			'middle'     => $body->middle,
			'high'       => $body->high,
			'very_high'  => $body->very_high,
		]);
		return $guide;
	}

	public function findGuideByTypeAndName(string $type, string $name): Collection
	{
		return $this->guide->where('status', ($type !== $this->guide::DISABLE))
			->where('name', 'like', "%{$name}%")
			->get();
	}

	public function countGuidesById(array $guidesId): array
	{
		return $this->guide::with('qualification')
			->whereIn('id', $guidesId)->get()
			->sortBy(function ($model) use ($guidesId) {
				return array_search($model->id, $guidesId);
			})->values()->toArray();;
	}

	public function deleteGuide(string $guideId)
	{
		return $this->guide::where('id', $guideId)->delete();
	}

	public function findGuideWithQualification(string $guideId): ?Guide
	{
		return $this->guide::with(['survey:id', 'survey:pivot.qualification'])->find($guideId);
	}

	public function findGuideBySurvey(string $surveyId, string $guideId): ?Guide
	{
		return $this->guide
			->whereHas('surveys', function ($query) use ($surveyId) {
				$query->where('surveys.id', $surveyId);
			})->with(['surveys' => function ($query) use ($surveyId) {
				$query->where('surveys.id', $surveyId)->first();
			}, 'surveys:id', 'surveys:pivot'])

			->find($guideId);
	}

	public function changeGuideSurveyStatus(Guide $guide, string $surveyId, GuideStatus $status)
	{
		$survey = $guide->surveys()->where('survey_id', $surveyId)
			->with('guides')
			->first();

		$guides = $survey->guides;
		$guides->map(function ($currentguide) use ($guide, $surveyId, $status) {
			if ($currentguide->id === $guide->id) {
				$currentguide->surveys()->updateExistingPivot($surveyId, ['status' => $status->value]);
				return $currentguide;
			}
			if ($currentguide->pivot->status == GuideStatus::INPROGRESS->value) {
				$currentguide->surveys()->updateExistingPivot($surveyId, ['status' => GuideStatus::PAUSED->value]);
				return $currentguide;
			}
			return $currentguide;
		});

		return $this->findGuideBySurvey($surveyId, $guide->id);
	}

	public function findGuideDetail(string $guideId): ?Guide
	{
		return $this->guide::with([
			'sections' => function ($query) {
				$query->orderBy('position', 'asc')->select('id', 'name', 'guide_id', 'binary', 'can_finish_guide', 'question', 'position');
			},
			'sections.questions' => function ($query) {
				$query->select('id', 'name', 'section_id', 'qualification_id', 'type');
			},
			'sections.questions.qualification' => function ($query) {
				$query->select('id', 'name', 'always_op', 'almost_alwyas_op', 'sometimes_op', 'almost_never_op', 'never_op');
			},
		])
			->select('id', 'name', 'gradable', 'status',)
			->find($guideId);
	}
}
