<?php

use App\Models\BlogAuthor;
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
        Schema::create('blog_authors', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer('sort_order')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        for ($i = 0; $i < 2; $i++) {
            BlogAuthor::create([
                'name' => 'author' . $i,
                'sort_order' => $i
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_authors');
    }
};
