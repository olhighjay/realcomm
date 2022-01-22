<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();;
            $table->text('description')->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('business_category_id');
            $table->bigInteger('subscription_id');
            $table->integer('bank_account_number')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->boolean('bank_details_verified')->nullable()->default(false);
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->enum('status', ['active', 'inactive', 'blacklisted'])->default('active');
            $table->boolean('deactivated')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
