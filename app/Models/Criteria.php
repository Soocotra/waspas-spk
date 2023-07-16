<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function alternatifCriterias(){
        return $this->hasMany(alternativeCriteria::class);
    }

    function scopeOnProject(Builder $query, int $projectId)
    {
        return $query->whereHas('alternative', function ($query) use ($projectId) {
            return $query->where('project_id', $projectId);
        });
    }
}
