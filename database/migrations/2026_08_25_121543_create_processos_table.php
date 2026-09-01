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
        Schema::create('processos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_cliente')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('id_advg')->constrained('users')->cascadeOnDelete();
            $table->string('num_processo');
            $table->string('tipo_processo');
            $table->string('desc_processo');
            $table->date('data_abertura_processo');
            $table->string('status_processo');
            $table->string('vara_processo');
            $table->string('comarca');
            $table->string('tribunal_processo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processos');
    }
};
