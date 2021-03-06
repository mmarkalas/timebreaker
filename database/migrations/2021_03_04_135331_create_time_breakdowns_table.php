<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->timestamp("from_date")->nullable();
            $table->timestamp("to_date")->useCurrent();
            $table->text("expression");
            $table->text("result");
            $table->string("encoded_request")->nullable();
            $table->timestamps();

            $table->index('encoded_request');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_breakdowns');
    }
}
