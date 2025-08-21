<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstrukturSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'instruktur@gmail.com'],
            [
                'name' => 'Instruktur',
                'password' => Hash::make('Instruktur123'),
                'role' => 'instruktur',
            ]
        );
    }
}
