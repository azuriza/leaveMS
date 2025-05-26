<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('tahun');
            $table->integer('jatah_cuti')->default(12); // default jatah cuti per tahun
            $table->integer('cuti_terpakai')->default(0); // total yang sudah dipakai
            $table->integer('carry_over')->default(0); // sisa cuti tahun sebelumnya
            $table->timestamps();

            $table->unique(['user_id', 'tahun']); // agar tidak ada duplikat per user per tahun
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_balances');
    }
}
