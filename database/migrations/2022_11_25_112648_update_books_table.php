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
        Schema::table('books', function (Blueprint $table) {
            $table->biginteger('user_id')->comment('ユーザーID')->after('id');
            $table->string('title')->after('user_id')->comment('タイトル');
            $table->text('detail')->nullable()->after('title')->comment('詳細');
            $table->string('img_path')->nullable()->after('detail')->comment('画像の絶対パス');
            $table->string('remarks')->nullable()->after('img_path')->comment('備考');
            $table->integer('evaluation')->nullable()->after('remarks')->comment('評価');
            $table->string('category')->nullable()->after('evaluation')->comment('カテゴリ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('title');
            $table->dropColumn('detail');
            $table->dropColumn('img_path');
            $table->dropColumn('remarks');
            $table->dropColumn('evaluation');
            $table->dropColumn('category');
        });
    }
};
