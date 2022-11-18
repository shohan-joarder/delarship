<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('full_name')->nullable();
            $table->string('brand_name')->nullable();

            $table->integer('city')->unsigned()->nullable();
            $table->integer('vendor')->unsigned()->nullable();

            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->integer('role'); // ['0', '1', '2', '3'] 0 = inactive 1=admin 2=vendor 3=user
            $table->enum('gender', ['0', '1']);
            $table->boolean('status')->default('0');
            $table->string('photo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('otp')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        User::updateOrCreate([
            'username'   => 'Admin',
            'role'    => '1',
            'phone'  => '+8801776446562',
            'gender'     => '0',
            'email'      => 'admin@gmail.com',
            'password'   =>  Hash::make('password'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
