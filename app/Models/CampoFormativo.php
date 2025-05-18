<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampoFormativo extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'campo_formativos';

    protected $fillable = [
        'id',
        'name',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_campo_formativo', 'campo_formativo_id', 'project_id');
    }
}
