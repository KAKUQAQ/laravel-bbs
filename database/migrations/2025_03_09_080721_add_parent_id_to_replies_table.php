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
        Schema::table('replies', function (Blueprint $table) {
            $table->integer('parent_id')->unsigned()->nullable()->index()->comment('父级回复ID');
            $table->foreign('parent_id')->references('id')->on('replies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('replies', function (Blueprint $table) {
            if (Schema::hasColumn('replies', 'parent_id')) {
                $table->dropForeign(['parent_id']); // 删除外键
                $table->dropColumn('parent_id');    // 删除字段
            }
        });
    }
};
