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
        /** 
         * Migracion de la tabla Category con las propiedades solicitadas en el documento
         */
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('code_category', 10)->unique(); //Codigo Debe ser unico
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('parent_id')->nullable(); // Campo Foreign Key que que permite establecer relacion jerarquica entre categorias
            $table->timestamps();

            /**
             * Definicion de Relaciones
             * Una categoria se relacion consigo misma
             */
            $table->foreign('parent_id')
            ->references('id')
            ->on('categories')
            ->onUpdate('cascade')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
