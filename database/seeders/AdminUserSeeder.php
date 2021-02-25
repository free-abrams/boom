<?php

namespace Database\Seeders;

use App\Models\AdminUser;
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
        AdminUserFactory::times(20)->create();
        
        $admin = AdminUser::find(1);
        $admin->username = 'admin@admin';
        $admin->save();
        $admin->assignRole('super_admin');
    }
}
