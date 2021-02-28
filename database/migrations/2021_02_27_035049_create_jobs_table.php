<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', '50');
            $table->string('email', '100');
            $table->text('address');
            $table->string('gender', 10);
            $table->string('phone', 15);
            $table->integer('location_id')->nullable()->unsigned();
            $table->string('expected_ctc', 15)->nullable();
            $table->string('current_ctc', 15)->nullable();
            $table->string('notice_period', 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
