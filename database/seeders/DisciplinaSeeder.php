<?php

namespace Database\Seeders;

use App\Models\Disciplina;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DisciplinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $disciplinas = [
            'Español',
            'Inglés',
            'Artes',
            'Matemáticas',
            'Biología',
            'Física',
            'Química',
            'Geografía',
            'Historia',
            'Formación Cívica y Ética',
            'Tecnología',
            'Educación Física',
            'Educación Socioemocional/Tutoría'
        ];

        foreach ($disciplinas as $disciplina) {
            Disciplina::create([
                'id' => Str::uuid(),
                'name' => $disciplina
            ]);
        }
    }
}
