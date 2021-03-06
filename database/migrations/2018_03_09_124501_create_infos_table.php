<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->nullable();
            $table->string('school_name')->nullable();
            $table->string('name');
            $table->string('sex');
            $table->string('grade');
            $table->string('ta_tel');
            $table->string('my_tel');
            $table->string('height');
            $table->string('brith_place');
            $table->text('detail');
            $table->text('expect');
            $table->string('upload_url');
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
        Schema::dropIfExists('infos');
    }
}
