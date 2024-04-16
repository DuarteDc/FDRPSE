<?php

namespace App\infrastructure\repositories\guideUser;

use App\domain\guideUser\GuideUser;
use App\domain\guideUser\GuideUserRepository as ContractsRepository;
use App\infrastructure\repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

final class GuideUserRepository extends BaseRepository implements ContractsRepository
{
	public function __construct(private readonly GuideUser $guideUser)
	{
		parent::__construct($guideUser);
	}

	public function setUser(string $surveyUserId, string $userId): void
	{
		$this->guideUser::find($surveyUserId)->attach($userId);
	}

	public function setSurvey(string $surveyUserId, string $surveyId): void
	{
		$this->guideUser::find($surveyUserId)->attach($surveyId);
	}

	public function getCurrentGuideUser(string $guideId, string $userId, string $surveyId)
	{
		$guideUser = $this->guideUser::Where('guide_id', $guideId)
			->where('user_id', $userId)
			->where('survey_id', $surveyId)
			->first();

		return $guideUser ? $guideUser : $this->create(
			['guide_id' => $guideId, 'user_id' => $userId, 'survey_id' => $surveyId]
		);
	}

	public function saveAnswer(GuideUser $guideUser, mixed $body): GuideUser
	{
		$guideUser->answers = $body;
		$guideUser->save();
		return $guideUser;
	}

	public function getUserAnwserInCurrentSurvey(string $userId): ?GuideUser
	{
		return $this->guideUser::where('status', false)->where('user_id', $userId)->first();
	}

	public function finalizeGuideUser(
		string $surveyId,
		string $guideId,
		string $userId,
		int $userQualification
	): GuideUser {
		$surveyUser = $this->guideUser::where('guide_id', $guideId)
			->where('survey_id', $surveyId)
			->where('user_id', $userId)
			->first();
		$surveyUser->status = GuideUser::FINISHED;
		$surveyUser->total  = $userQualification;
		$surveyUser->save();
		return $surveyUser;
	}

	public function canAvailableSurveyPerUser(string $userId): ?GuideUser
	{
		return $this->guideUser::where('user_id', $userId)
			->where('status', false)
			->first();
	}

	public function getDetailsSurveyUser(string $surveyId, string $guideId)
	{
		// id,nombre,userName,apellidoP,apellidoM,id_area',
		return $this->guideUser::where('survey_id', $surveyId)
			->where('guide_id', $guideId)
			->with([
				'guide:id,name',
				'user' => function ($query) {
					$query->where('nombre', 'EDUARDO');
				},
				'user.area:id,nombreArea',
				'user.area.subdirections',
			])
			->get(['user_id', 'total', 'status']);
	}

	public function searchByNameAndAreas(
		string $surveyId,
		string $guideId,
		string $name,
		string $areaId = '',
		string $subareaId = ''
	) {
		$guidesUser = $this->guideUser::where('survey_id', $surveyId)
			->where('guide_id', $guideId)
			->with([
				'user' => function ($query) use ($name) {
					return $query->where('nombre', 'like', "%$name%")
						->orWhere('apellidoP', 'like', "%$name%")
						->orWhere('apellidoM', 'like', "%$name%");
				},
				'user:id,nombre,userName,apellidoP,apellidoM,id_area',
				'user.area' => function ($query) use ($areaId, $subareaId) {
					if (!$areaId && !$subareaId) {
						return $query;
					}
					if ($areaId && !$subareaId) {
						$query->where(function ($q) use ($areaId) {
							$q->where('area_padre', $areaId)
								->orWhereHas('father', function ($subquery) use ($areaId) {
									$subquery->where('area_padre', $areaId)->where('area_nivel', '>', 1);
								})
								->orWhere('id', $areaId);
						});
					} elseif (!$areaId && $subareaId) {
						$query->where('id', $subareaId);
					} else {
						$query->where(function ($q) use ($areaId, $subareaId) {
							$q->where('area_padre', $areaId)
								->where('id', $subareaId);
						})->orWhereHas('father', function ($subquery) use ($areaId, $subareaId) {
							$subquery->where('area_padre', $areaId)
								->where('id', $subareaId);
						});
					}
				},
			])
			->orderBy('id', 'desc')
			->get(['user_id', 'total', 'status', 'guide_id']);



		return collect([...$guidesUser->filter(function ($guide) {
			return $guide->user !== null && $guide->user->area !== null;
		})]);
	}

	public function getDetailsByUser(string $surveyId, string $userId, string $guideId): ?GuideUser
	{
		return $this->guideUser::where('survey_id', $surveyId)->where('user_id', $userId)
			->where('guide_id', $guideId)
			->with(['user:id,nombre,apellidoP,apellidoM,id_area', 'user.area:id,nombreArea'])
			->first(['user_id', 'total', 'status', 'answers']);
	}

	public function findCurrentSurveyUser(string $userId): GuideUser
	{
		return $this->guideUser::where('user_id', $userId)
			->where('status', true)
			->with(['guide:id,name', 'user:id,nombre,apellidoP,apellidoM,id_area', 'user.area:id,nombreArea'])
			->latest()->first(['user_id', 'total', 'status', 'answers', 'guide_id']);
	}

	public function countSurveyUserAnswers(string $surveyId): int
	{
		return $this->guideUser::where('survey_id', $surveyId)->count();
	}

	public function findUserGuideBySurvey(string $surveyId, string $guideId): ?Collection
	{
		return $this->guideUser::with(['user:id,nombre,userName,apellidoP,apellidoM,id_area', 'user.area:id,nombreArea'])
			->where('guide_id', $guideId)
			->where('survey_id', $surveyId)
			->get(['id', 'guide_id', 'user_id', 'survey_id', 'status', 'total', 'created_at', 'updated_at']);
	}

	public function clearOldAnswers(GuideUser $guideUser): GuideUser
	{
		$guideUser->answers = [];
		$guideUser->status  = GuideUser::INPROGRESS;
		$guideUser->save();
		return $guideUser;
	}


	public function countGudesUsersAvailable(string $surveyId, string $guideId): int
	{
		return $this->guideUser::where('survey_id', $surveyId)->where('guide_id', $guideId)
			->where('status', GuideUser::FINISHED)->count();
	}
}
