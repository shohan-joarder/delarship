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
        Schema::create('real_wedding_pages', function (Blueprint $table) {
            $table->id();

            $table->string('main_baner')->nullable();;
            $table->string('main_baner_title_1')->nullable();;
            $table->string('main_baner_title_2')->nullable();;
            $table->string('middle_banner')->nullable();;
            $table->string('middle_banner_content_1')->nullable();;
            $table->string('middle_banner_content_2')->nullable();;
            $table->string('bottom_banner')->nullable();;
            $table->string('bottom_banner_content_1')->nullable();;
            $table->string('bottom_banner_content_2')->nullable();;
            $table->longText('real_wedding_page_meta')->nullable();

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
        Schema::dropIfExists('real_wedding_pages');
    }
};
