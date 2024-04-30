<?php


namespace App\application\question;

use App\domain\category\CategoryRepository;
use App\domain\dimension\DimensionRepository;
use App\domain\domain\DomainRepository;
use App\domain\qualification\QualificationRepository;
use App\domain\section\SectionRepository;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class QuestionService implements QuestionServiceContracts
{
	public function __construct(
		private readonly CategoryRepository $categoryRepository,
		private readonly QualificationRepository $qualificationRepository,
		private readonly SectionRepository $sectionRepository,
		private readonly DomainRepository $domainRepository,
		private readonly DimensionRepository $dimensionRepository,
	) {}

	public function categoryIsValid(string $id, string|null $qualificationId): Exception|Model
	{
		$category = $this->categoryRepository->findOneWithQualification($id, $qualificationId);
		return $category ? $category : new Exception('La categoría no es valida', 400);
	}

	public function qualificationIsValid(string $id): Exception|Model
	{
		$qualification = $this->qualificationRepository->findOne($id);
		return $qualification ? $qualification : new Exception('La calificaión no es valida', 400);
	}

	public function sectionIsValid(string $id): Exception|Model
	{
		$section = $this->sectionRepository->findOne($id);
		return $section ? $section : new Exception('La sección no es valida', 400);
	}

	public function domainIsValid(string $id, string|null $qualificationId): Exception|Model
	{
		$domain = $this->domainRepository->findOneWithQualification($id, $qualificationId);
		return $domain ? $domain : new Exception('El dominio no es valido', 400);
	}

	public function dimensionIsValid(string $id): Exception|Model
	{
		$dimension = $this->dimensionRepository->findOne($id);
		return $dimension ? $dimension : new Exception('La dimensión no es valida', 400);
	}

	public function getQuestionsBySections(): Collection
	{
		return $this->sectionRepository->findSectionsWithQuestions();
	}

	public function getQuestionBySection(string $guideId, string $page): Paginator|null
	{
		return $this->sectionRepository->findSectionWithQuestions($guideId, $page);
	}

	public function getTotalSections(string $guideId): int
	{
		return $this->sectionRepository->countTotalSections($guideId);
	}

	public function prepareDataToInsert(mixed $body): array|Exception
	{
		$exitsQualification = $this->qualificationIsValid((string) $body->qualification_id);
		$exitsSection       = $this->sectionIsValid((string) $body->section_id);
		$exitsDimension     = $this->dimensionIsValid((string) $body->dimension_id);

		if ($exitsQualification instanceof Exception) {
			return $exitsQualification;
		}
		if ($exitsSection instanceof Exception) {
			return $exitsSection;
		}
		if ($exitsDimension instanceof Exception) {
			return $exitsDimension;
		}

		return [
			'qualification' => $exitsQualification,
			'section'       => $exitsSection,
			'dimension'     => $exitsDimension,
		];
	}
}
