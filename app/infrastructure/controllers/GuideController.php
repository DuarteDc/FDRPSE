<?php

declare(strict_types=1);

namespace App\infrastructure\controllers;

use App\application\guide\GuideUseCase;
use App\infrastructure\requests\guide\CreateGuideRequest;
use App\kernel\controllers\Controller;

final class GuideController extends Controller
{
    public function __construct(private readonly GuideUseCase $guideUseCase) {}

    public function getGuides()
    {
        $this->response($this->guideUseCase->getAllGuides());
    }
    public function showGuide(string $guideId)
    {
        $this->response($this->guideUseCase->findGuide($guideId));
    }

    public function showGuideBySurvey(string $surveyId, string $guideId)
    {
        $this->response($this->guideUseCase->showGuideBySurvey($surveyId, $guideId));
    }

    public function createGuide()
    {
        $this->validate(CreateGuideRequest::rules(), CreateGuideRequest::messages());
        $this->response($this->guideUseCase->createGuide($this->request()));
    }

    public function getGuidesByCriteria()
    {
        $type = (string) $this->get('type');
        $name = (string) $this->get('name');

        $this->response($this->guideUseCase->searchGuidesByTypeAndName($type, $name));
    }

    public function disableGudie(string $gudieId)
    {
        $this->response($this->guideUseCase->findAndDisableGudie($gudieId));
    }

    public function enableGudie(string $gudieId)
    {
        $this->response($this->guideUseCase->findAndEnableGudie($gudieId));
    }

    public function getGuideDetail(string $guideId)
    {
        $this->response($this->guideUseCase->findGuideDetail($guideId));
    }
}
