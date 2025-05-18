<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectSession extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected $table = 'project_sessions';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'project_id',
        'sesion',
        'duracion',
        'instrucciones_estudiante',
        'instrucciones_docente'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function materials()
    {
        return $this->hasMany(SessionMaterial::class, 'project_session_id');
    }

}
