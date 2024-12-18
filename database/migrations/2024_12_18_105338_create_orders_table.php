<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cliente');
            $table->string('telefono_cliente');
            $table->string('email_cliente')->nullable();
            $table->string('metodo_pago');
            $table->decimal('total', 10, 2);
            $table->string('restaurante');
            $table->text('direccion');
            $table->json('ubicacion')->nullable();
            $table->enum('estado', ['pendiente', 'preparando', 'enviando', 'entregado'])->default('pendiente');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->integer('producto_id');
            $table->string('nombre_producto');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
