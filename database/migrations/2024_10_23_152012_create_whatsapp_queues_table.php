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
        Schema::create('whatsapp_queues', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->on('users')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->bigInteger('transaction_mail_id')->unsigned();
            $table->foreign('transaction_mail_id')->on('transaction_mails')->references('id');
            $table->string('current_status');
            $table->string('last_status')->nullable(true);
            $table->boolean('request_notified')->default(false);
            $table->date('request_notified_at')->nullable(true);
            $table->boolean('notified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_queues');
    }
};
