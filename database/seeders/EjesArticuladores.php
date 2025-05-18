<?php

namespace Database\Seeders;

use App\Models\Disciplina;
use App\Models\EjeArticulador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EjesArticuladores extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ejesArticuladores = [
            ['name' => 'Apropiación de las culturas a través de la lectura y la escritura', 'image_url' => 'lectura.png'],
            ['name' => 'Apreciación de las culturas a través de la lectura y la escritura', 'image_url' => 'lectura.png'],
            ['name' => 'Pensamiento crítico', 'image_url' => 'pensamiento.png'],
            ['name' => 'Inclusión', 'image_url' => 'inclusion.png'],
            ['name' => 'Interculturalidad crítica', 'image_url' => 'interculturalidad.png'],
            ['name' => 'Igualdad de género', 'image_url' => 'genero.png'],
            ['name' => 'Vida saludable', 'image_url' => 'vida_saludable.png'],
            ['name' => 'Artes y experiencias estéticas', 'image_url' => 'artes.png'],

        ];

        foreach ($ejesArticuladores as $eje) {
            EjeArticulador::create([
                'id' => Str::uuid(),
                'name' => $eje['name'],
                'image_url' => $eje['image_url'],
            ]);
        }
    }
}
