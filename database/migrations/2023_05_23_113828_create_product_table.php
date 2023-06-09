<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('symbol');
            $table->string('description');
            $table->boolean('status')->default(true)->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('sale', 8, 2)->nullable();
            $table->string('description')->nullable();
            $table->boolean('status')->default(true)->nullable();
            $table->string('product_type_code')->nullable();
            $table->foreign('product_type_code')->references('code')->on('product_types')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('description')->nullable();
            $table->boolean('status')->default(true)->nullable();
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->boolean('status')->default(true)->nullable();
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->boolean('status')->default(true)->nullable();
            $table->timestamps();
        });

        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->string('product_code');
            $table->string('material_code');
            $table->string('unit_code');
            $table->integer('material_quantity')->nullable();
            $table->foreign('product_code')->references('code')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('material_code')->references('code')->on('materials')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('unit_code')->references('code')->on('units')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->string('product_code');
            $table->string('invoice_code');
            $table->foreign('product_code')->references('code')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('invoice_code')->references('code')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity_product')->default(0)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
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
        Schema::dropIfExists('invoice_details');
        Schema::dropIfExists('product_details');
        Schema::dropIfExists('units');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_types');
    }
};
