<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone_number');
            $table->enum('role', ['guest', 'customer', 'vendor']);
            $table->enum('gender', ['male', 'female','other']);
            $table->string('address');
            $table->string('state');
            $table->date('dob')->nullable();
            $table->foreignId('current_team_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->enum('status', ['active', 'inactive', 'blacklisted'])->default('active');
            $table->boolean('deactivated')->nullable()->default(false);
            $table->boolean('verified')->nullable()->default(false);
            $table->string('profile_picture')->nullable();
            
        });
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
}
