<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutoringRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutoring_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('tutor_id');
            $table->unsignedBigInteger('advertisement_id');
            $table->string('request_status')->default('Pending');
            $table->string('requested_date');
            $table->string('requested_time');
            $table->string('tutorial_joining_url');
            $table->string('comment')->nullable();
            $table->foreign('student_id')->references('student_id')->on('student_profiles');
            $table->foreign('tutor_id')->references('tutor_id')->on('tutor_profiles');
            $table->foreign('advertisement_id')->references('id')->on('tutor_advertisements');
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
        Schema::dropIfExists('tutoring_requests');
    }
}
