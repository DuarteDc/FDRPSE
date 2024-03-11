<?php

namespace App\infrastructure\repositories\guide;

use App\domain\guide\Guide;
use App\domain\guide\GuideRepository as ContractsGuideRepository;
use App\infrastructure\repositories\BaseRepository;


class GuideRepository extends BaseRepository implements ContractsGuideRepository
{

    public function __construct(private readonly Guide $guide)
    {
        parent::__construct($guide);
    }

    public function findByName(string $name): ?Guide
    {
        return $this->guide->where('name', $name)->first();
    }

    public function disableGuide(string $guideId): Guide
    {
        return $this->guide::find($guideId)->update(['status' => false]);
    }

}
