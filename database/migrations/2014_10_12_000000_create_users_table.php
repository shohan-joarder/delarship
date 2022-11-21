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

            $table->decimal('average_ratings')->nullable();
            $table->integer('reviews')->nullable();

            $table->integer('view_count')->nullable();

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
        User::updateOrCreate([
            'username'   => 'Vendor',
            'full_name' => "Vendors",
            'status' => 1,
            'role'    => '2',
            'phone'  => '+8801776446502',
            'gender'     => '0',
            'email'      => 'vendor@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password'   =>  Hash::make('password'),
        ]);
        User::updateOrCreate([
            'username'   => 'User',
            'full_name' => "Users",
            'status' => 1,
            'role'    => '3',
            'phone'  => '+8801776446552',
            'gender'     => '0',
            'email'      => 'user@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
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
