<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreHandoverIdsToApplyleavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applyleaves', function (Blueprint $table) {
            $table->unsignedBigInteger('handover_id_2')->nullable()->after('handover_id');
            $table->unsignedBigInteger('handover_id_3')->nullable()->after('handover_id_2');

            // Jika kamu ingin relasi foreign key, bisa tambahkan ini:
            $table->foreign('handover_id_2')->references('id')->on('users')->onDelete('set null');
            $table->foreign('handover_id_3')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applyleaves', function (Blueprint $table) {
            $table->dropColumn(['handover_id_2', 'handover_id_3']);
        });
    }
}
