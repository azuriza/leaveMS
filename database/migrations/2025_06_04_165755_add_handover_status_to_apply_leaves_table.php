<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHandoverStatusToApplyLeavesTable extends Migration
{
    public function up()
    {
        Schema::table('applyleaves', function (Blueprint $table) {
            $table->boolean('handover_status')->default(0)->after('handover_id'); // ganti 'nama_kolom_terakhir' sesuai kebutuhan
        });
    }

    public function down()
    {
        Schema::table('applyleaves', function (Blueprint $table) {
            $table->dropColumn('handover_status');
        });
    }
}
