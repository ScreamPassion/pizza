<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketsTable extends Migration
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
            $table->integer('uid')->default(null)->nullable(true);
            $table->string('session', 255)->default(null)->nullable(true);
            $table->text('address')->nullable();
            $table->string('email',255)->nullable();
            $table->string('name',255)->nullable();
            $table->decimal('price', 10,2)->default("0.00")->nullable();
            $table->tinyInteger('ordered')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
