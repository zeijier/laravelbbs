<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

//        当用户删除时，删除其发布的话题；
//        当用户删除时，删除其发布的回复；
//        当话题删除时，删除其所属的回复；
        Schema::table('topics',function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDeleted('cascade');
        });
        Schema::table('replies',function (Blueprint $table){
            // 当 user_id 对应的 users 表数据被删除时，删除此条数据
            $table->foreign('user_id')->references('id')->on('users')->onDeleted('cascade');
            // 当 topic_id 对应的 topics 表数据被删除时，删除此条数据
            $table->foreign('topic_id')->references('id')->on('topics')->onDeleted('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics',function (Blueprint $table){
            // 移除外键约束
           $table->dropForeign(['user_id']);
        });
        Schema::table('replies',function (Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['topic_id']);
        });
    }
}
