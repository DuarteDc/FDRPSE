<?php

namespace App\domain\guideUser;

use App\domain\guide\Guide;
use App\domain\survey\Survey;
use Illuminate\Database\Eloquent\Model;
use App\domain\user\User;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GuideUser extends Pivot
{
    const INPROGRESS = false;
    const FINISHED   = true;

    protected $table = 'guide_survey_user';
    protected $fillable = ['guide_id', 'user_id', 'survey_id', 'answers', 'status', 'total'];
    protected $casts = ['answers' => 'json'];

    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

}
