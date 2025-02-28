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
              'name'=>'Shared',
              'description'=>'Exploration and Discovery',
          ],
          [
              'name'=>'Tutorial',
              'description'=>'Learning by Practicing',
          ],
          [
              'name'=>'Discussion',
              'description'=>'Do Not Answer',
          ],
          [
              'name'=>'Announcement',
              'description'=>'Site Announcement',
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
