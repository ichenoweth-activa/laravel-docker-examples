<?php

namespace Database\Seeders;

use App\Models\Metodologia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MetodologiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodologias = [
            'Aprendizaje Basado en Problemas',
            'Aprendizaje Basado en Proyectos',
            'Aprendizaje Servicio',
            'Aprendizaje basado en la Indagación con enfoque en STEAM'
        ];

        foreach ($metodologias as $metodologia) {
            Metodologia::create([
                'id'   => Str::uuid(),
                'name' => $metodologia,
            ]);
        }
    }
}
