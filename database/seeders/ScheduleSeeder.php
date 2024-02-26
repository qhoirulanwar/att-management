<?php

namespace Database\Seeders;

use App\Models\ScheduleHour;
use App\Models\ScheduleShift;
use App\Models\ScheduleShiftHour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScheduleHour::create([
            'name' => 'Normal',
            'start_time' => '08:00',
            'end_time' => '17:00',
            'check_in_time1' => '6:00',
            'check_in_time2' => '14:00',
            'check_out_time1' => '16:00',
            'check_out_time2' => '23:00',
        ]);

        ScheduleShift::create([
            'name' => 'Non Shift',
            // 'start_date' => '2020-01-01',
            // 'end_date' => '2099-12-31',
            // 'cycle' => 1,
            // 'unit' => 1,
        ]);

        for ($i = 1; $i < 6; $i++) {
            ScheduleShiftHour::create([
                'schedule_shift_id' => 1,
                'start_time' => '08:00',
                'end_time' => '17:00',
                's_days' => $i,
                'e_days' => $i,
                'schedule_hour_id' => 1
            ]);
        }

    }
}
