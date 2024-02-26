<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\Location;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class InitializeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Host']);
        Role::create(['name' => 'Karyawan']);

        Department::create([
            'name' => 'Our Department',
            'structure' => '/',
            'parent_department_id' => null
        ]);

        Location::create([
            'name' => 'Primary Location',
            'address' => 'Our Location address',
        ]);

        LeaveType::create([
            'name' => 'Sakit',
            'min_unit' => 1,
            'unit' => 1,
            'symbol' => 'S',
            'color' => '#ff9933'
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        Employee::create([
            'name' => 'admin',
            'user_id' => 1,
            'department_id' => 1,
            'location_id' => 1
        ]);

    }
}
