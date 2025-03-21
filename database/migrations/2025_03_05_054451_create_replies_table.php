<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
	public function up()
	{
		Schema::create('replies', function(Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->integer('topic_id')->unsigned()->default(0)->index()->comment('对应话题ID');
            $table->bigInteger('user_id')->unsigned()->default(0)->index()->comment('回复用户ID');
            $table->text('message')->comment('回复内容');
            $table->timestamps();
            $table->comment('话题回复表');
        });
	}

	public function down()
	{
		Schema::drop('replies');
	}
};
