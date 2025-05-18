<?php

namespace Database\Seeders;

use App\Models\CampoFormativo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CampoFormativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campos = [
            'Lenguajes',
            'De lo humano y lo comunitario',
            'Ética, naturaleza y sociedades',
            'Sáberes y pensamiento científico',
            'Ciencias Sociales o AC',
            'Conciencia Histórica',
            'Humanidades',
            'Lengua y Comunicación',
            'Ciencias Naturales, Experimentales y Tecnología',
            'Pensamiento Matemático',
            'Cultura Digital',
            'Inglés',
        ];

        foreach ($campos as $campo) {
            CampoFormativo::create([
                'id'   => Str::uuid(),
                'name' => $campo,
            ]);
        }
    }
}
