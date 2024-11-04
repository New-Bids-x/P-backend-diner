<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoRestaurantesTable extends Migration
{
    public function up()
    {
        Schema::create('pedido_restaurantes', function (Blueprint $table) {
            $table->id();
            $table->json('pedido'); // Guarda el pedido como un JSON
            $table->string('total'); // Total del pedido
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido_restaurantes');
    }
}
