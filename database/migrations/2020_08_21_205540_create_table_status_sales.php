<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\StatusSales;

class CreateTableStatusSales extends Migration
{
    public function up()
    {
        Schema::create(StatusSales::TABLE, function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('description', 10)->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(StatusSales::TABLE);
    }
}
