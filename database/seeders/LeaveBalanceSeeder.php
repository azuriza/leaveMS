<?php

namespace Database\Seeders; 

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LeaveBalance;
use Illuminate\Support\Carbon;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tahun = Carbon::now()->year;
        $jatahCuti = 12;

        $users = User::all();

        foreach ($users as $user) {
            // Cek dulu agar tidak duplikat
            $existing = LeaveBalance::where('user_id', $user->id)
                ->where('tahun', $tahun)
                ->exists();

            if (!$existing) {
                LeaveBalance::create([
                    'user_id' => $user->id,
                    'tahun' => $tahun,
                    'jatah_cuti' => $jatahCuti,
                    'carry_over' => 0,
                    'cuti_terpakai' => 0,
                ]);
            }
        }

        $this->command->info("Leave balances untuk tahun $tahun berhasil di-generate.");
    }
}
