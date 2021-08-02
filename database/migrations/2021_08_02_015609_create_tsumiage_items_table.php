<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsumiageItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsumiage_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('item1');
            $table->string('item2');
            $table->string('item3');
            $table->string('item4');
            $table->string('item5');
            $table->string('item6');
            $table->string('item7');
            $table->string('item8');
            $table->string('item9');
            $table->string('item10');
            $table->string('item12');
            $table->string('item13');
            $table->string('item14');
            $table->string('item15');
            $table->string('item16');
            $table->string('item17');
            $table->string('item18');
            $table->string('item19');
            $table->string('item20');
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
        Schema::dropIfExists('tsumiage_items');
    }
}
