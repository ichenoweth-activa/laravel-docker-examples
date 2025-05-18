<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectAreaConocimiento extends Pivot
{
    use HasFactory;

    use SoftDeletes;
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'project_area_conocimiento';

    protected $fillable = [
        'project_id',
        'area_conocimiento_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function areaConocimiento()
    {
        return $this->belongsTo(AreaConocimiento::class, 'area_conocimiento_id');
    }

}
