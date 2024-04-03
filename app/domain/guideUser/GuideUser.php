<?php

namespace App\domain\guideUser;

use App\domain\guide\Guide;
use Illuminate\Database\Eloquent\Model;
use App\domain\user\User;

class GuideUser extends Model
{
    const INPROGRESS = false;
    const FINISHED   = true;

    protected $table = 'guide_user';
    protected $fillable = ['guide_id', 'user_id', 'answers', 'status', 'total'];
    protected $casts = ['answers' => 'json'];

    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
