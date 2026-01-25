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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('merchant');
            $table->string('password');
            $table->string('english_name');
            $table->string('national_id')->unique();
            $table->enum('entry_type', [
                'trader_Person',
                'licensed_company',
                'person',
                'unlicensed_activity'
            ]);
            $table->rememberToken(); 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('iban')->unique();
            $table->string('public_code');
            $table->string('mobile')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
