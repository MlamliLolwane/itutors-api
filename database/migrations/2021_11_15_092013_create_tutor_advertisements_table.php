<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('content');
            $table->string('price');
            $table->integer('max_participants')->default(1);
            $table->string('duration')->nullable();
            $table->string('ad_type');//Once off or reoccuring
            $table->unsignedBigInteger('tutor_id');
            $table->string('subject_id');
            $table->foreign('tutor_id')->references('tutor_id')->on("tutor_profiles");
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
        Schema::dropIfExists('tutor_advertisements');
    }
}
