<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationPlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_platforms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('application_id');
            $table->string('name');
            $table->string('type');
            $table->string('key')->nullable();
            $table->string('secret')->nullable();
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
        Schema::dropIfExists('application_platforms');
    }
}
