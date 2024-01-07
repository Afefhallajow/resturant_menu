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
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references("id")->on('categories')->onDelete('cascade');

            $table->bigInteger('subcategory_id')->unsigned()->nullable();
            $table->foreign('subcategory_id')->references("id")->on('subcategories')->onDelete('cascade');

            $table->string("name");
            $table->double('discount');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
