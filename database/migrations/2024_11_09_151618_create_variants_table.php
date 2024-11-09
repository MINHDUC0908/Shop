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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('parameter');
            $table->string('attribute')->nullable();
            $table->json('colors');
            $table->decimal('price', 12, 2);
            $table->integer('quantity')->default(0);
            $table->enum('status', ['available', 'out_of_stock'])->default('available');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variants');
    }
};
