<?php
namespace App\Traits;
use Auth;
use Illuminate\Support\Facades\Schema;

trait CudSupport
{
    public static function boot()
    {  
        parent::boot();
        
        static::updating(function ($model) {
            if(Auth::user())
                $model->updated_by = Auth::user()->id;
        });
        
        static::deleting(function ($model) {
            if(Auth::user() && Schema::hasColumn($model->getTable(), "deleted_by"))            
                $model->deleted_by = Auth::user()->id;
           $model->save();
        });
        
        static::saving(function ($model) {
            if ($model->id && Auth::user()) { 
                $model->updated_by = Auth::user()->id;
            }
            else{
                if(Auth::user())
                    $model->created_by = Auth::user()->id;
            }
        });

    }

    public function createdBy() { 
        return $this->belongsTo('App\Models\User','created_by','id');
    }  

    public function createdAt()
    {
        if ($this->created_at)
            return $this->created_at->format('D j F, Y');

        return null;
    }

    public function updatedBy() { 
        return $this->belongsTo('App\Models\User','updated_by','id');
    }  

    public function updatedAt()
    {
        if($this->updated_at)
            return $this->updated_at->format('D j F, Y');

        return null;
    }

    public function deletedBy() { 
        return $this->belongsTo('App\Models\User','deleted_by','id');
    }  

    public function deletedAt()
    {
        if($this->deleted_at)
            return $this->deleted_at->format('D j F, Y');

        return null;
    }

}