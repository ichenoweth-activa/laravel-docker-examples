<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disciplina extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    public $incrementing = false;
    protected $table = 'disciplinas';
    protected $keyType = 'string';
    protected $fillable = ['id','name'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_disciplina', 'disciplina_id', 'project_id');
    }

}
