<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("price");
            $table->enum("status",\Nrz\Order\Models\Order::STATUSES)
                ->default(\Nrz\Order\Models\Order::STATUS_WAITING);
            $table->enum("consume_location",\Nrz\Order\Models\Order::LOCATE);
            $table->unsignedInteger("quantity");
            $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id")->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("product_id")->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("attribute_id")->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("value_id")->constrained("attribute_values","id")->onDelete("cascade")->onUpdate("cascade");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('orders');
    }
}
