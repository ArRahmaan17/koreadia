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
        Schema::create('event_queues', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_schedule_id')
                ->unsigned();
            $table->foreign('event_schedule_id')
                ->references('id')
                ->on('event_schedules')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->bigInteger('employee_id')
                ->unsigned();
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->boolean('request_broadcast')->default(false);
            $table->boolean('broadcast')->default(false);
            $table->dateTimeTz('request_broadcasted_at')->nullable(true);
            $table->dateTimeTz('broadcasted_at')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_queues');
    }
};
