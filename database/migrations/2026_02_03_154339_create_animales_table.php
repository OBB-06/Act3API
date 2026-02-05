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
        Schema::create('animales', function (Blueprint $table) {
            $table->id('id_animal');
            $table->string('nombre');
            $table->enum('tipo', ['perro', 'gato', 'hamster', 'conejo']);
            $table->decimal('peso', 8, 2)->nullable();
            $table->string('enfermedad')->nullable();
            $table->text('comentarios')->nullable();

            // Relación con propietarios (clave foránea)
            $table->unsignedBigInteger('id_persona')->nullable();
            $table->foreign('id_persona')
                  ->references('id_persona')
                  ->on('propietarios')
                  ->onDelete('cascade'); // Si se elimina el dueño, se eliminan sus animales

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animales');
    }
};
