<?php

namespace Modules\Match\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\Traits\CudSupport;

class Set extends Model
{
    use SoftDeletes, CudSupport;
    protected $fillable = ['name', 'set', 'question'];

    public function matches()
    {
        return $this->hasMany('\Modules\Match\Entities\Match');
    }
}
