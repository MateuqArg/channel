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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('custid');
            $table->integer('event_id');
            $table->boolean('approved')->nullable()->default(null);
            $table->boolean('present')->nullable()->default(null);
            $table->boolean('vip')->default(0);
            $table->string('name');
            $table->string('email');
            $table->biginteger('phone');
            $table->string('company');
            $table->string('charge');
            $table->string('state');
            $table->string('city');
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
        Schema::dropIfExists('visitors');
    }
};
