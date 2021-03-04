<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToJobTechnicalExperiences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_technical_experiences', function (Blueprint $table) {
            $table->boolean('is_selected')->default(0)->after('technology');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_technical_experiences', function (Blueprint $table) {
            $table->dropColumn('is_selected');
        });
    }
}
