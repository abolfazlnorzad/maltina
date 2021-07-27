<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId("attribute_id")->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->string("value");
            $table->timestamps();
        });


        Schema::create('attribute_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("attribute_id")->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("value_id")->constrained("attribute_values","id")->onDelete("cascade")->onUpdate("cascade");
            $table->unique(["product_id","attribute_id","value_id"]);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_product');
        Schema::dropIfExists('attribute_values');
        Schema::dropIfExists('attributes');
    }
}
