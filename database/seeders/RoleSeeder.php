<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo role super_admin nếu chưa có
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // Tạo người dùng admin mặc định
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin', // Giữ nguyên field cũ để tương thích
            ]
        );

        // Gán role super_admin
        $admin->assignRole($superAdminRole);
        
        $this->command->info('Admin user created with email: admin@gmail.com and password: password');
    }
}
