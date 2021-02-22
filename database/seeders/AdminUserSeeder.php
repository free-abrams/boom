<?php

namespace Database\Seeders;

use Database\Factories\AdminUserFactory;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminUserFactory::times(1)->create();
    }
}
