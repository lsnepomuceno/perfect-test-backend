<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Customers;

class CreateTableCustomers extends Migration
{
    public function up()
    {
        Schema::create(Customers::TABLE, function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name', 64)->nullable(false);
            $table->string('email', 128)->unique()->nullable()->default(null);
            $table->string('cpf', 14)->unique()->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Customers::TABLE);
    }
}
