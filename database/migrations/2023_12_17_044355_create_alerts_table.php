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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zone_id');
            $table->text('area_description')->nullable();
            $table->dateTime('sent')->nullable();
            $table->dateTime('effective')->nullable();
            $table->dateTime('onset')->nullable();
            $table->dateTime('expires')->nullable();
            $table->dateTime('ends')->nullable();
            $table->string('status')->nullable();
            $table->string('severity')->nullable();
            $table->string('certainty')->nullable();
            $table->string('urgency')->nullable();
            $table->string('event')->nullable();
            $table->string('sender')->nullable();
            $table->text('headline')->nullable();
            $table->text('description')->nullable();
            $table->text('instruction')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
