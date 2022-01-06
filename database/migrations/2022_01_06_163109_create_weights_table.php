<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->double('weight', 4, 1)->comment('体重(小数点以下1桁)')->nullable();
            $table->text('breakfast')->comment('朝食')->nullable();
            $table->text('lunch')->comment('昼食')->nullable();
            $table->text('supper')->comment('晩飯')->nullable();
            $table->text('snack')->comment('間食')->nullable();
            $table->integer('breakfast_calories')->comment('朝食のカロリー')->nullable();
            $table->integer('lunch_calories')->comment('昼食のカロリー')->nullable();
            $table->integer('supper_calories')->comment('晩飯のカロリー')->nullable();
            $table->integer('snack_calories')->comment('間食のカロリー')->nullable();
            $table->integer('total_calories')->comment('1日のトータル摂取カロリー')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weights');
    }
}
