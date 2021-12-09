<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('name', 225);
            $table->text('description');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->string('creator');
            $table->string('editor');
            $table->timestamps();

            $table->index(['id', 'employee_id', 'name', 'description', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_jobs');
    }
}
