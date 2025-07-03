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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('file_number')->nullable();
            $table->string('object')->nullable();
            $table->string('description')->nullable();
            $table->string('path')->nullable();
            $table->string('type')->default('arrival');
            $table->string('status')->default('draft');
            $table->string('sender_name')->nullable();
            $table->string('destination_name')->nullable();;
            $table->string('tags')->nullable();
            $table->date('date_arrival')->nullable();
            $table->date('date_sent')->nullable();
            $table->string('observation')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_private')->default(false);
            $table->unsignedTinyInteger('priority')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('destination_id')->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            // Add foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('destination_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
