<?php

namespace Modules\Question\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\Traits\CudSupport;
use Spatie\Permission\Traits\HasRoles;

class Question extends Model
{
    use SoftDeletes, CudSupport, HasRoles;
    protected $fillable = ['content', 'data'];
    protected $guard_name = 'web';

    public function getDataAttribute()
    {

        if (isset($this->attributes['data']))
            return json_decode($this->attributes['data']);
        else
            return null;
    }

    public function answer(){
        return $this->hasMany('\Modules\Match\Entities\Answer');
    }

    public function scopeNotAnswered($query, $match_id){
        return $query->whereDoesntHave('answer', function ($query) use($match_id) {
            $query->where('match_id', $match_id);
        });
    }
}
