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
    Schema::create('episodios', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->integer('numero');
        $table->unsignedBigInteger('temporada_id'); // Foreign keys devem ser unsigned

        $table->foreign('temporada_id') // Nome deve ser idêntico à coluna criada acima
            ->references('id')
            ->on('temporadas');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodios');
    }
};
