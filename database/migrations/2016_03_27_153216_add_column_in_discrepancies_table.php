<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInDiscrepanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('discrepancies', function (Blueprint $table) {
            $table->string('is_major');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('discrepancies', function (Blueprint $table) {
            $table->dropColumn('is_major');
        });
    }
}
