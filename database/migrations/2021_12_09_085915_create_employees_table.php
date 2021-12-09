<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 20);
            $table->string('first_name', 225);
            $table->string('last_name', 225)->nullable();
            $table->string('born_palce', 225)->nullable();
            $table->date('born_date')->nullable();
            $table->integer('gender')->comment('1 Laki-laki, 2 Perempuan');
            $table->integer('religion')->comment('1 islam, 2 kristen, 3 hindu, 4 budha, 5')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->date('in_date')->nullable();
            $table->date('out_date')->nullable();
            $table->integer('departement_id');
            $table->integer('position_id');
            $table->integer('status')->comment('1 active, 2 inactive');
            $table->string('creator');
            $table->string('editor');
            $table->timestamps();

            $table->index(['id', 'nik', 'first_name', 'last_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
