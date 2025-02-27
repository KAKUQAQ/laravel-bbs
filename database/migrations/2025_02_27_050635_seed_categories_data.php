<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        $categories = [
          [
              'name'=>'分享',
              'description'=>'探索与发现',
          ],
          [
              'name'=>'教程',
              'description'=>'做中学',
          ],
          [
              'name'=>'问答',
              'description'=>'不要回答',
          ],
          [
              'name'=>'公告',
              'description'=>'站点公告',
          ]
        ];
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
};
