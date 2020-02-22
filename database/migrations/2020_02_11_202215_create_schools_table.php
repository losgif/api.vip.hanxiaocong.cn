<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->string('name')->nullable();
            $table->string('media_number')->nullable();
            $table->string('avatar_image')->nullable();
            $table->string('media_id');
            $table->string('token');
            $table->string('media_type')->nullable();
            $table->string('media_url')->nullable();
            $table->string('school_name')->nullable();
            $table->string('school_code')->nullable();
            $table->tinyInteger('verify_type')->nullable();
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
        Schema::dropIfExists('schools');
    }
}
