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
        Schema::create('temporadas', function (Blueprint $table) {
            $table->bigIncrements(column:'id');
            $table->integer(column:'numero');
            $table->integer(column:'serie_id');

            $table->foreign(columns:'serie_id')
            ->references('id')
            ->on('series');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporadas');
    }
};
