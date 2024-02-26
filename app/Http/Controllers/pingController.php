<?php

namespace App\Http\Controllers;

use App\Models\ScheduleEmployee;
use App\Models\ScheduleShiftHour;
use App\Services\dateTimeService;
use Illuminate\Http\Request;
use DateTime;

// use Barryvdh\Debugbar\Facade as Debugbar;

class pingController extends Controller
{

    public $dateTimeService;

    public function __construct()
    {
        $this->dateTimeService = new dateTimeService();
        // print_r($this->dateTimeService->handle());
    }

    public function getSchedulesEmployeeByDateRange($employeeId, $startDate, $endDate)
    {
        $data = [];

        $schedulesEmployee = ScheduleEmployee::where('employee_id', $employeeId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate]);
            })->get();

        $scheduleShiftHours = ScheduleShiftHour::where('schedule_shift_id', $schedulesEmployee[0]->schedule_shift_id)
            ->with(['scheduleShift', 'scheduleHour'])->get();

        $data['tanggal'] = date('Y-m-d', strtotime("2024-02-23"));
        $data['schedulesEmployee'] = $schedulesEmployee;
        $data['schedulesShiftHour'] = $scheduleShiftHours;

        $data['schedule_start_date'] = $schedulesEmployee[0]->start_date;
        $data['schedule_end_date'] = $schedulesEmployee[0]->end_date;
        $data['now'] = date('Y-m-d');
        $data['isDateInRange'] = $this->isDateInRange(date('Y-m-d'), $data['schedule_start_date'], $data['schedule_end_date']);
        $data['hitung_siklus'] = $this->hitungSiklusMingguan('2024-02-01', $data['tanggal']);

        return $data;

    }

    public function isDateInRange($date, $start_date, $end_date): bool
    {
        return $date >= $start_date && $date <= $end_date;
    }

    public function hitungSiklusMingguan($tanggal_mulai, $tanggal_inti, $cycle = 2, $unit = 1)
    {
        $jumlahSenin = 0;
        // $cycle = 3;
        $tanggal = $tanggal_mulai;
        $seninDates = [];
        $seninDatesCycles = [];

        // apabila tanggal mulai bukan senin maka mundur ke minggu sebelumnya
        if (date('N', strtotime($tanggal_mulai)) != '1') {
            $tanggal = $this->kurangiHari($tanggal_mulai, 7 - date('N', strtotime($tanggal_mulai)));
        }

        while ($tanggal <= $tanggal_inti) {
            if (date('N', strtotime($tanggal)) === '1') {
                $jumlahSenin++;
                $seninDates[] = date('Y-m-d', strtotime($tanggal));
            }
            $tanggal = date('Y-m-d', strtotime($tanggal . ' +1 day'));
        }

        for ($i = 0; $i < count($seninDates); $i += $cycle) {
            $seninDatesCycles[] = $seninDates[$i];
        }

        $siklus_akhir = end($seninDatesCycles);

        return $this->hitungSelisihHari($siklus_akhir, $tanggal_inti) + 1 . ' ' . $siklus_akhir . ' ' . $tanggal_inti;
    }

    function hitungSelisihHari($tanggalAwal, $tanggalAkhir)
    {
        $awal = new DateTime($tanggalAwal);
        $akhir = new DateTime($tanggalAkhir);

        // Hitung selisih hari
        $interval = $awal->diff($akhir);
        $selisihHari = $interval->days;

        return $selisihHari;
    }

    function kurangiHari($tanggal, $jumlahHari)
    {
        $tgl = new DateTime($tanggal);
        $tgl->modify("-$jumlahHari day");
        return $tgl->format('Y-m-d');
    }

}
