<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EjeArticulador extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'ejes_articuladores';

    protected $fillable = ['id', 'name','image_url'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_eje_articulador')
            ->using(ProjectEjeArticulador::class);
    }
}
