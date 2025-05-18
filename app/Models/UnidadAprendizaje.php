<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnidadAprendizaje extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'unidad_aprendizaje';

    protected $fillable = ['id', 'name'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_unidad_aprendizaje')
            ->using(ProjectUnidadAprendizaje::class);
    }
}
