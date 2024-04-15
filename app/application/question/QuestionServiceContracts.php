<?php

declare(strict_types=1);

namespace App\application\question;

use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface QuestionServiceContracts
{
	public function categoryIsValid(string $id, string $qualificationId): Exception|Model;
	public function qualificationIsValid(string $id): Exception|Model;
	public function sectionIsValid(string $id): Exception|Model;
	public function domainIsValid(string $id, string $qualificationId): Exception|Model;
	public function prepareDataToInsert(mixed $body): array|Exception;
	public function getQuestionsBySections(): Collection;
	public function getQuestionBySection(string $guideId, string $page): Paginator|null;
	public function getTotalSections(string $guideId): int;
}
