<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected $table = 'projects';


    protected $fillable = [
        'id_original_ip',
        'nombre',
        'contenido',
        'descripcion',
        'lenguaje',
        'proceso_desarrollo_aprendizaje',
        'nivel',
        'semestre',
        'producto',
        'subproducto',
        'escenario',
        'grado_escolar',
        'status',
        'classroom_id',
        'materiales_listos',
        'file_id',
        'file_name',
        'url_location_file',
        'implementado_por_user_id',
    ];
/*



*/
    public function projectSession()
    {
        return $this->hasMany(ProjectSession::class, 'project_id');
    }

    public function implementadoPor()
    {
        return $this->belongsTo(User::class, 'implementado_por_user_id');
    }


    public function metodologias()
    {
        return $this->belongsToMany(Metodologia::class, 'project_metodologia', 'project_id', 'metodologia_id')
            ->using(ProjectMetodologia::class);
    }

    public function campoFormativos()
    {
        return $this->belongsToMany(CampoFormativo::class, 'project_campo_formativo', 'project_id', 'campo_formativo_id')
            ->using(ProjectCampoFormativo::class);
    }

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'project_disciplina', 'project_id', 'disciplina_id')
            ->using(ProjectDisciplina::class);
    }

    public function unidadesAprendizaje()
    {
        return $this->belongsToMany(UnidadAprendizaje::class, 'project_unidad_aprendizaje')
            ->using(ProjectUnidadAprendizaje::class)
            ->withTimestamps();
    }

    public function areaConocimientos()
    {
        return $this->belongsToMany(AreaConocimiento::class, 'project_area_conocimiento')
            ->using(ProjectAreaConocimiento::class)
            ->withTimestamps();
    }

    public function ejesArticuladores()
    {
        return $this->belongsToMany(EjeArticulador::class, 'project_eje_articulador')
            ->using(ProjectEjeArticulador::class);
    }

}
