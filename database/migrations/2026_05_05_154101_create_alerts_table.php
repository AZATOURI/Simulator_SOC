<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('category'); // Brute Force, SQL Injection, Malware...
            $table->text('description');

            $table->enum('severity', ['Low', 'Medium', 'High', 'Critical'])->default('Medium');
            $table->enum('status', ['New', 'In Progress', 'Resolved', 'False Positive'])->default('New');

            $table->string('source_ip')->nullable();
            $table->string('target_system')->nullable();
            $table->text('recommendation')->nullable();
            $table->text('raw_log')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
