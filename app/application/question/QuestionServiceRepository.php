<?php

namespace App\application\question;

use Exception;
use Illuminate\Database\Eloquent\Model;

interface QuestionServiceRepository
{
    
    public function categoryIsValid(string $id): Model | Exception;
    public function qualificationIsValid(string $id): Model | Exception;
    public function sectionIsValid(string $id): Model | Exception;
    public function domainIsValid(string $id): Model | Exception;
    public function prepareDataToInsert(mixed $body): Exception | array;

}
