<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function alternatifCriterias()
    {
        return $this->hasMany(alternativeCriteria::class);
    }
    function scopeRankByProject(Builder $query, int $projectId)
    {
        return $query->where('project_id', $projectId)->orderBy('rank');
    }
}
