<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectUnidadAprendizaje extends Pivot
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'project_unidad_aprendizaje';

    protected $fillable = [
        'id',
        'project_id',
        'unidad_aprendizaje_id',
    ];

    public function unidadAprendizaje()
    {
        return $this->belongsTo(UnidadAprendizaje::class, 'unidad_aprendizaje_id');
    }
}
