<?php

namespace Database\Seeders;

use App\Models\UnidadAprendizaje;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UnidadAprendizajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = [
            'Ciencias Sociales I', 'Ciencias Sociales II', 'Ciencias Sociales III',
            'Conciencia Histórica I', 'Conciencia Histórica II', 'Conciencia Histórica III',
            'Humanidades I', 'Humanidades II', 'Humanidades III',
            'Lengua y Comunicación I', 'Lengua y comunicación II', 'Lengua y Comunicación III',
            'La materia y sus interacciones CENEYT I',
            'Conservación de la energía y sus interacciones con la material CNEYT II',
            'Ecosistema, interacciones, energía y dinámica CNEYT III',
            'Reacciones químicas conservación de la materia en la formación de nuevas sustancias CNEYT IV',
            'La energía en los procesos de la vida CNEYT V',
            'Organismos, estructuras y procesos. Herencia y evolución biológica CNEYT VI',
            'Pensamiento Matemático I', 'Pensamiento Matemático II', 'Pensamiento Matemático III',
            'Cultura DIgital I', 'Cultura Digital II', 'Cultura digital III',
            'Inglés I', 'Inglés II', 'Inglés III', 'Inglés IV', 'Inglés V', 'Inglés VI',
        ];

        foreach ($unidades as $nombre) {
            UnidadAprendizaje::create([
                'id' => Str::uuid(),
                'name' => $nombre,
            ]);
        }
    }
}
