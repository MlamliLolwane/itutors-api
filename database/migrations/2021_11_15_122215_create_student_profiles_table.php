<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id');
            $table->primary('student_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('study_level');
            $table->string('description')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->foreign('student_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_profiles');
    }
}
