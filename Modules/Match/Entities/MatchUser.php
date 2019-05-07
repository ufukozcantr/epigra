<?php

namespace Modules\Match\Entities;

use Illuminate\Database\Eloquent\Model;

class MatchUser extends Model
{
    protected $table = 'match_user';

    public function match()
    {
        return $this->belongsTo('\Modules\Match\Entities\Match');
    }

    public function firstUser()
    {
        return $this->belongsTo('\App\User', 'first_user');
    }

    public function secondUser()
    {
        return $this->belongsTo('\App\User', 'second_user');
    }

    public function matchSets()
    {
        return $this->hasMany('\Modules\Match\Entities\MatchSet', 'match_user_id')->with('answers');
    }

    public function set()
    {
        return $this->belongsTo('\Modules\Match\Entities\Set');
    }
}
