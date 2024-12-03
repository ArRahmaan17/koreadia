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
        Schema::create('detail_event_schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_schedule_id')
                ->unsigned();
            $table->foreign('event_schedule_id')
                ->references('id')
                ->on('event_schedules')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('name');
            $table->string('speaker');
            $table->string('location')->nullable(true);
            $table->time('time');
            $table->boolean('online');
            $table->jsonb('meeting')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_event_schedules');
    }
};
