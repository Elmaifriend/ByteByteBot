<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Intent;

class IntentSeeder extends Seeder
{
    public function run(): void
    {
        Intent::factory()->count(10)->create();
    }
}
