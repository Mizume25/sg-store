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
         * 
         * Migracion para la tabla Rates
         */
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('price')->unsigned(); // Debe ser positivo
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            /** Definicion de Relaciones */
            $table->foreign('product_id')
            ->references('id')
            ->on('products')
            ->onUpdate('cascade')
            ->onDelete('restrict');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
