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
        Schema::table('tasks', function (Blueprint $table) {
            $table->biginteger('user_id')->comment('ユーザーID')->after('id');
            $table->DATE('limit')->after('user_id')->comment('タスク期限');
            $table->string('title')->after('limit')->comment('タイトル');
            $table->text('detail')->after('title')->comment('詳細');
            $table->string('img_path')->after('detail')->comment('画像のパス');
            $table->string('remarks')->after('img_path')->comment('備考');
            $table->integer('status')->after('remarks')->comment('ステータス');
            $table->string('category')->after('status')->comment('カテゴリ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('limit');
            $table->dropColumn('title');
            $table->dropColumn('detail');
            $table->dropColumn('img_path');
            $table->dropColumn('remarks');
            $table->dropColumn('status');
            $table->dropColumn('category');
        });
    }
};
