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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Relación con categorías
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Guardará la ruta de la imagen
            $table->decimal('base_price', 8, 2)->nullable(); // Precio de costo (opcional)
            $table->decimal('selling_price', 8, 2);        // Precio de venta
            $table->integer('quantity')->default(0);      // Cantidad en stock
            $table->boolean('is_active')->default(true); // Para activar/desactivar productos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
