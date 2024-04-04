<?php

namespace App\application\question;

use App\domain\section\Section;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface QuestionServiceRepository
{
    public function categoryIsValid(string $id): Model | Exception;
    public function qualificationIsValid(string $id): Model | Exception;
    public function sectionIsValid(string $id): Model | Exception;
    public function domainIsValid(string $id): Model | Exception;
    public function prepareDataToInsert(mixed $body): Exception | array;
    public function getQuestionsBySections(): Collection;
    public function getQuestionBySection(string $guideId, string $page): Paginator | null;
    public function getTotalSections(string $guideId): int;
}
