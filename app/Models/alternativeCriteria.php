<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alternativeCriteria extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }

}
