<?php

namespace Modules\Match\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\Traits\CudSupport;

class Match extends Model
{
    use SoftDeletes, CudSupport;
    protected $fillable = ['question', 'set_id'];

    public function set()
    {
        return $this->belongsTo('\Modules\Match\Entities\Set');
    }

    public function user(){
        return $this->belongsToMany('Modules\Match\Entities\User')->withPivot('user_id', 'match_id');
    }
}
