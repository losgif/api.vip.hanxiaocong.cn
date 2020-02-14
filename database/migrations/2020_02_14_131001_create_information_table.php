<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('school_id');
            $table->string('school_name');
            $table->string('name');
            $table->string('sex');
            $table->string('contact_account');
            $table->string('university');
            $table->string('department');
            $table->string('height');
            $table->string('constellation');
            $table->string('origin');
            $table->string('weibo');
            $table->string('specialty');
            $table->string('person_image');
            $table->text('extra');
            $table->integer('is_active')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('information');
    }
}
