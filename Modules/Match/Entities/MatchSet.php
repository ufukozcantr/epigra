<?php

namespace Modules\Match\Entities;

use Illuminate\Database\Eloquent\Model;

class MatchSet extends Model
{
    protected $table = 'match_set';

    public function set()
    {
        return $this->belongsTo('\Modules\Match\Entities\Set');
    }

    public function matchUser()
    {
        return $this->belongsTo('\Modules\Match\Entities\MatchUser');
    }

    public function answers()
    {
        return $this->hasMany('\Modules\Match\Entities\Answer');
    }
}
