<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SessionMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;
    protected $primaryKey = 'id';

    protected $fillable = [
        'project_session_id',
        'nombre_material',
        'liga',
        'file_id',
    ];

    public function ProjectSession()
    {
        return $this->belongsTo(ProjectSession::class, 'project_session_id');
    }

}
