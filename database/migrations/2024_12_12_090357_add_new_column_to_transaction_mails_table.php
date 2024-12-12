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
        Schema::table('whatsapp_queues', function (Blueprint $table) {
            $table->addColumn('BigInteger', 'validator_id')->unsigned()->default(1);
            $table->foreign('validator_id')->on('users')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_queues', function (Blueprint $table) {
            $table->dropColumn('validator_id');
            $table->dropForeign('validator_id');
        });
    }
};
