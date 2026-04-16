<?php

namespace Database\Seeders;

use App\Models\Enrollee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrolleeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Enrollee::create([
            'student_id' => '230001',
            'name' => 'Maria Santos',
            'course' => 'BSCS',
            'year' => 1,
            'block' => 'A',
        ]);

        Enrollee::create([
            'student_id' => '230002',
            'name' => 'Juan dela Cruz',
            'course' => 'BSIT',
            'year' => 2,
            'block' => 'B',
        ]);

        Enrollee::create([
            'student_id' => '230003',
            'name' => 'Ana Reyes',
            'course' => 'BSEMC-GD',
            'year' => 3,
            'block' => 'C',
        ]);

        Enrollee::create([
            'student_id' => '230004',
            'name' => 'Carlo Bautista',
            'course' => 'BSCS-EMC DAT',
            'year' => 1,
            'block' => 'D',
        ]);
    }
}