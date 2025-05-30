<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateAnnualLeaveBalance extends Command
{
    protected $signature = 'leave:generate-balance';
    protected $description = 'Generate leave balances for current year from previous year';

    public function handle()
    {
        $currentYear = now()->year;
        $lastYear = $currentYear - 1;

        $affected = DB::insert("
            INSERT INTO leave_balances (user_id, tahun, jatah_cuti, carry_over, created_at, updated_at)
            SELECT
                user_id,
                ? AS tahun,
                12 AS jatah_cuti,
                GREATEST(0, jatah_cuti - cuti_terpakai) AS carry_over,
                NOW(), NOW()
            FROM leave_balances
            WHERE tahun = ?
        ", [$currentYear, $lastYear]);

        $this->info("Leave balances generated for year $currentYear");
    }
}
