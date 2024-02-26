<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\ScheduleEmployee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $month = '02';

        for ($i = 1; $i < 29; $i++) {

            Attendance::create([
                'employee_id' => 1,
                'check_time' => "2022-{$month}-{$i} 07:50:00",
            ]);

            Attendance::create([
                'employee_id' => 1,
                'check_time' => "2022-{$month}-{$i} 17:10:00",
            ]);
        }

        ScheduleEmployee::create([
            'employee_id' => 1,
            'schedule_shift_id' => 1,
            'start_date' => '2024/2/1',
            'end_date' => '2099/12/31',
        ]);

    }
}
