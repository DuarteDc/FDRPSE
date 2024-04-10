<?php

namespace App\domain\guide;

use App\domain\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface GuideRepository extends BaseRepository
{
    public function findByName(string $name): ?Guide;
    public function disableGuide(string $guideId): Guide;
    public function createAndSetQualification(object  $body): Guide;
    public function setGuideQualification(Guide $guide, object $body): Guide;
    public function findGuideByTypeAndName(string $type, string $name): Collection;
    public function countGuidesById(array $guidesId): array;
    public function deleteGuide(string $guideId);
    public function findGuideWithQualification(string $guideId):? Guide;
    public function findGuideBySurvey(string $surveyId, string $guideId):? Guide;
}
