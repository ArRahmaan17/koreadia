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
        Schema::create('transaction_mails', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->comment('Mail Number (receipt)');
            $table->string('regarding');
            $table->dateTime('date')->comment('Mail Date');
            $table->string('sender');
            $table->string('sender_phone_number');
            $table->string('file_attachment');
            $table->enum('status', [
                'ARCHIVE',
                'IN',
                'PROCESS',
                'FILED',
                'DISPOSITION',
                'REPLIED',
                'OUT',
            ]);
            $table->dateTime('date_in')->comment('Mail in date');
            $table->bigInteger('agenda_id')->unsigned();
            $table->foreign('agenda_id')
                ->references('id')
                ->on('mail_agendas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->bigInteger('priority_id')->unsigned();
            $table->foreign('priority_id')
                ->references('id')
                ->on('mail_priorities')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->bigInteger('type_id')->unsigned();
            $table->foreign('type_id')
                ->references('id')
                ->on('mail_types')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->bigInteger('creator_id')->unsigned();
            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('sincerely')->nullable(true);
            $table->string('note')->nullable(true);
            $table->string('reply_file_attachment')->nullable(true);
            $table->string('reply_note')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_mails');
    }
};
