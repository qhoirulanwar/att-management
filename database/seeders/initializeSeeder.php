<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class initializeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('roles')->insert(['name' => 'Admin']);
        DB::table('roles')->insert(['name' => 'Host']);
        DB::table('roles')->insert(['name' => 'Karyawan']);

        DB::table('departments')->insert([
            'name' => 'Our Department',
            'structure' => '/',
            'parent_department_id' => null
        ]);

        DB::table('locations')->insert([
            'name' => 'Our Location',
            'address' => 'Our Location address',
        ]);

        DB::table('employees')->insert([
            'name' => 'admin',
            'user_id' => 1,
            'department_id' => 1,
            'location_id' => 1
        ]);

        DB::table('leave_types')->insert([
            'name' => 'Sakit',
            'min_unit' => 1,
            'unit' => 1,
            'symbol' => 'S',
            'color' => '#ff9933'
        ]);
    }
}
