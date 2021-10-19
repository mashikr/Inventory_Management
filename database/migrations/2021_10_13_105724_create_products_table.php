<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id');
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->integer('buying_price')->nullable();
            $table->integer('selling_price');
            $table->bigInteger('supplier_id')->nullable();
            $table->string('buying_date')->nullable();
            $table->string('image')->nullable();
            $table->integer('product_quantity');
            $table->timestamps();
            $table->foreignId('category_id')->constrained('categories') ->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers') ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
