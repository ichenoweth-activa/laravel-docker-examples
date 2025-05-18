<?php

namespace Database\Seeders;

use App\Models\AreaConocimiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AreaConocimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            'Ciencias Sociales',
            'Conciencia Histórica',
            'Humanidades',
            'Lengua y Comunicación',
            'Ciencias naturales, experimentales y tecnología',
            'Pensamiento Matemático',
            'Cultura Digital',
            'Inglés'
        ];

        foreach ($areas as $area) {
            AreaConocimiento::create([
                'id' => Str::uuid(),
                'name' => trim($area)
            ]);
        }
    }
}
