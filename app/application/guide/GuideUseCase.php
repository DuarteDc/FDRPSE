<?php

namespace App\application\guide;

use App\domain\guide\GuideRepository;
use Exception;

class GuideUseCase
{

    public function __construct(private readonly GuideRepository $guideRepository)
    {
    }

    public function getAllGuides()
    {
        $guides = $this->guideRepository->findAll();
        return ['guides' => $guides];
    }

    public function createGuide(mixed $body)
    {
        $name = $this->validateName($body->name);
        if ($name instanceof Exception) return $name;

        $guide = $this->guideRepository->createAndSetQualification((object)[...(array)$body, 'name' => $name]);
        return ['message' => 'EL cuestionario se creo correctamente', 'guide' => $guide];
    }

    public function disableGuide(string $guideId)
    {

        $guide = $this->guideRepository->findOne($guideId);
        if (!$guide) return new Exception('El cuestionario ya ha sidio desactivado');
        $this->guideRepository->disableGuide($guideId);
    }

    private function validateName(string $name): Exception | string
    {
        $name = trim(mb_strtoupper($name));
        $guide = $this->guideRepository->findByName($name);
        return $guide ? new Exception('Ya existe un cuestionario con ese nombre', 400) : $name;
    }

    public function searchGuidesByTypeAndName(string $type, string $name)
    {
        $type = trim(mb_strtolower($type));
        $name = trim(mb_strtoupper($name));

        return ['guides' => $this->guideRepository->findGuideByTypeAndName($type, $name)];
    }

}
