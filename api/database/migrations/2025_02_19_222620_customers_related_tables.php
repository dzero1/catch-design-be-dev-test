<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // basic customer information table
        Schema::create('customers', function (Blueprint $table) {
            // id,first_name,last_name,email,gender

            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('gender');
            $table->timestamps();
        });
        
        // customer ip_address record in a separate table. later we can use it to track the ip address changers
        Schema::create('customer_ip_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('ip_address');
            $table->timestamps();
        });

        // keep customer company related informations. company,city,title,website
        Schema::create('customer_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('company');
            $table->string('city');
            $table->string('title');
            
            // website can be longer than usual string length of 255. so we use text
            $table->text('website');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('customers_ip_address');
        Schema::dropIfExists('customers_companies');
    }
};
