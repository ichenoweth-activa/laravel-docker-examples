<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectCampoFormativo extends Pivot
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'project_campo_formativo';

    protected $fillable = [
        'id',
        'project_id',
        'campo_formativo_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function campoFormativo()
    {
        return $this->belongsTo(CampoFormativo::class, 'campo_formativo_id');
    }

}
