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
        Schema::create('real_weeding_posts', function (Blueprint $table) {
            $table->id();
            $table->string('weeding_category_id')->nullable();
            $table->integer('auther_id')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->string("title");
            $table->string("slug")->nullable();
            $table->longText('short_description');
            $table->longText('description');
            $table->string('photo')->nullable();
            $table->integer('status')->default(1);
            $table->string('tags')->nullable();

            $table->boolean('featured')->default(1);
            $table->boolean('comments')->default(1);

            $table->timestamp('publish_date')->useCurrent();
            $table->string('seo_title')->nullable();
            $table->longText('seo_description')->nullable();
            $table->longText('seo_keywords')->nullable();

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
        Schema::dropIfExists('real_weeding_posts');
    }
};
