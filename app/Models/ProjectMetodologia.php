<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectMetodologia extends Pivot
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'project_metodologia';

    protected $fillable = [
        'project_id',
        'metodologia_id',
    ];


    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }


    public function metodologia()
    {
        return $this->belongsTo(Metodologia::class, 'metodologia_id');
    }

}
