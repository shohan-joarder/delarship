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
        Schema::create('real_weeding_categories_real_weeding_post', function (Blueprint $table) {
            $table->id();
            $table->integer('real_weeding_post_id');
            $table->integer('real_weeding_categories_id');
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
        Schema::dropIfExists('real_weeding_post_categories');
    }
};
