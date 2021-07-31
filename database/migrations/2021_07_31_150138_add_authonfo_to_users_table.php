<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthonfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('twitter')->default(false)->comment('Twitterでログインフラグ');
            $table->text('nickname')->nullable()->comment('TwitterID');
            $table->text('profile_photo_path')->nullable()->comment('Twitterプロフィール画像パス');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('twitter');
            $table->dropColumn('nickname');
        });
    }
}
