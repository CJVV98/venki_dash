<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetrictsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->float('cognitivo')->default(0);
            $table->float('emocional')->default(0);
            $table->float('conductual')->default(0);
            $table->float('fortaleza_mental')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cognitivo');
            $table->dropColumn('emocional');
            $table->dropColumn('conductual');
            $table->dropColumn('fortaleza_mental');
        });
    }
}
