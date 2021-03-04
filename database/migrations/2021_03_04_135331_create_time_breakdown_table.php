<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeBreakdownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_breakdown', function (Blueprint $table) {
            $table->id();
            $table->timestamp("from_date")->nullable();
            $table->timestamp("to_date")->useCurrent();
            $table->json("expression");
            $table->json("result");
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
        Schema::dropIfExists('time_breakdown');
    }
}
