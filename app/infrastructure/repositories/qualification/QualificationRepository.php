<?php

declare(strict_types=1);

namespace App\infrastructure\repositories\qualification;

use App\domain\qualification\QualificationRepository as ContractsRepository;
use App\infrastructure\repositories\BaseRepository;

final class QualificationRepository extends BaseRepository implements ContractsRepository {}
