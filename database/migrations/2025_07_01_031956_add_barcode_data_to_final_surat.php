<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('final_surat', function (Blueprint $table) {
            $table->string('barcode_data')->nullable()->after('barcode');
        });
    }

    public function down()
    {
        Schema::table('final_surat', function (Blueprint $table) {
            $table->dropColumn('barcode_data');
        });
    }
};
