<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectEjeArticulador extends Pivot
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'project_eje_articulador';

    protected $fillable = ['id', 'project_id', 'eje_articulador_id'];

    public function ejeArticulador()
    {
        return $this->belongsTo(EjeArticulador::class, 'eje_articulador_id');
    }
}
