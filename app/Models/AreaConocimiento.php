<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaConocimiento extends Model
{
    use HasFactory;

    use SoftDeletes;
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'area_conocimientos';
    protected $fillable = ['name'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_area_conocimiento')
            ->using(ProjectAreaConocimiento::class);
    }


}
