<?php

namespace App\infrastructure\repositories\question;

use Illuminate\Database\Eloquent\Model;

use App\infrastructure\repositories\BaseRepository;
use App\domain\question\QuestionRepository as ConfigQuestionRepository;

class QuestionRepository extends BaseRepository implements ConfigQuestionRepository
{

    public function __construct(private readonly Model $model) {
        parent::__construct($model);
    }
    
}
