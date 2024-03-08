<?php

namespace App\infrastructure\controllers;

use App\application\guide\GuideUseCase;
use App\infrastructure\requests\guide\CreateGuideRequest;
use App\kernel\controllers\Controller;

class GuideController extends Controller
{

    public function __construct(private readonly GuideUseCase $guideUseCase)
    {
    }

    public function getGuides()
    {
        $this->response($this->guideUseCase->getAllGuides());
    }

    public function createGuide()
    {
        $this->validate(CreateGuideRequest::rules(), CreateGuideRequest::messages());
        $this->response($this->guideUseCase->createGuide($this->request()));
    }
}
