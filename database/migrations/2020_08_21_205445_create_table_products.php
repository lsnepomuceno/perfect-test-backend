<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Products;

class CreateTableProducts extends Migration
{
    public function up()
    {
        Schema::create(Products::TABLE, function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name', 128)->nullable(false);
            $table->string('image')->nullable(false);
            $table->string('description', 255)->nullable(false);
            $table->unsignedDecimal('price', 10, 2)->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Products::TABLE);
    }
}
