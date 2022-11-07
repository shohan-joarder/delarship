<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('in_house_services', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("sub_title");
            $table->string("url");
            $table->string("button_text");
            $table->string('photo');
            $table->integer('sort_order')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('in_house_services');
    }
};
