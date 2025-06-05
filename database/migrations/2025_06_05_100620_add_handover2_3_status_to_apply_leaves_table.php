<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHandover23StatusToApplyLeavesTable extends Migration
{
    public function up()
    {
        Schema::table('applyleaves', function (Blueprint $table) {
            $table->boolean('handover2_status')->default(0)->after('handover_id_2');
            $table->boolean('handover3_status')->default(0)->after('handover_id_3');
        });
    }

    public function down()
    {
        Schema::table('applyleaves', function (Blueprint $table) {
            $table->dropColumn(['handover2_status', 'handover3_status']);
        }); 
    }
}
