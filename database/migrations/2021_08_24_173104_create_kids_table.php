<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('identification');
            $table->boolean('active')->default(true);
            $table->string('responsable1_name');
            $table->string('responsable1_phone');
            $table->string('responsable2_name');
            $table->string('responsable2_phone');
            $table->string('photo');
            $table->foreignId('id_user')->references('id')->on('users');
            $table->foreignId('id_kid_class')->references('id')->on('kid_classes');
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
            Schema::dropIfExists('kids');
    }
}
