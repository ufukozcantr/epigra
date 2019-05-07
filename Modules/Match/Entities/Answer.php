<?php

namespace Modules\Match\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\Traits\CudSupport;

class Answer extends Model
{
    use SoftDeletes, CudSupport;
    protected $fillable = ['question_id', 'match_id', 'match_set_id', 'point'];

    public function matches()
    {
        return $this->hasMany('\Modules\Match\Entities\Match');
    }
}
