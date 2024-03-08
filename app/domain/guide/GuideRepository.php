<?php 

namespace App\domain\guide;

use App\domain\BaseRepository;

interface GuideRepository extends BaseRepository {

    public function findByName(string $name): ?Guide;

}