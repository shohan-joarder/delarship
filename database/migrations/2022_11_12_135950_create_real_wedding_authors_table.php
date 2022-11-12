<?php

use App\Models\RealWeddingAuthor;
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
        Schema::create('real_wedding_authors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_order');
            $table->timestamps();
        });
        for ($i = 0; $i < 2; $i++) {
            RealWeddingAuthor::create([
                'name' => 'author' . $i,
                'sort_order' => $i++
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
        Schema::dropIfExists('real_wedding_authors');
    }
};
