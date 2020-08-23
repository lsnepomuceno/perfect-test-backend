<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Sales, Products, StatusSales, Customers};

class CreateTableSales extends Migration
{
    public function up()
    {
        Schema::create(Sales::TABLE, function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('product_id')->constrained(Products::TABLE)->nullable(false)->onDelete('cascade');
            $table->foreignId('status_id')->constrained(StatusSales::TABLE)->nullable(false)->onDelete('cascade');
            $table->foreignId('customer_id')->constrained(Customers::TABLE)->nullable(false)->onDelete('cascade');
            $table->unsignedInteger('quantity')->nullable(false)->default(1);
            $table->unsignedDecimal('discount')->nullable()->default(0.0);
            $table->dateTime('sold_at')->nullable(false)->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Sales::TABLE);
    }
}
