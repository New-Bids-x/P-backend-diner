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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('administrador_id'); // Asumiendo que cada venta está asociada a un administrador
            $table->decimal('monto', 10, 2); // Monto de la venta
            $table->date('fecha'); // Fecha de la venta
            $table->string('cliente'); // Nombre del cliente
            $table->string('estado'); // Estado de la venta (ej. completada, pendiente)
            $table->timestamps();

            $table->foreign('administrador_id')->references('id')->on('administrador')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
