<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookmarksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bookmarks')->insert([
            'username' => 'tacck',
            'title' => str_random(10),
            'url' => 'http://' . str_random(20),
            'permalink' => 'http://' . str_random(20),
            'comment' => 'http://' . str_random(20),
            'is_private' => '1',
            'is_read_for_later' => '0',
            'htn_add_datetime' => '2018-01-01 23:59:59',
            'htn_add_date' => '2018-01-01',
            'user_id' => '1',
            'created_at' => '2018-01-01 23:59:59',
            'updated_at' => '2018-01-01 23:59:59',
        ]);
        DB::table('bookmarks')->insert([
            'username' => 'tacck',
            'title' => str_random(10),
            'url' => 'http://' . str_random(20),
            'permalink' => 'http://' . str_random(20),
            'comment' => 'http://' . str_random(20),
            'is_private' => '1',
            'is_read_for_later' => '0',
            'htn_add_datetime' => '2018-01-01 23:59:59',
            'htn_add_date' => '2018-01-01',
            'user_id' => '1',
            'created_at' => '2018-01-01 23:59:59',
            'updated_at' => '2018-01-01 23:59:59',
        ]);
        DB::table('bookmarks')->insert([
            'username' => 'tacck',
            'title' => str_random(10),
            'url' => 'http://' . str_random(20),
            'permalink' => 'http://' . str_random(20),
            'comment' => 'http://' . str_random(20),
            'is_private' => '1',
            'is_read_for_later' => '0',
            'htn_add_datetime' => '2018-01-01 23:59:59',
            'htn_add_date' => '2018-01-01',
            'user_id' => '1',
            'created_at' => '2018-01-01 23:59:59',
            'updated_at' => '2018-01-01 23:59:59',
        ]);
        DB::table('bookmarks')->insert([
            'username' => 'tacck',
            'title' => str_random(10),
            'url' => 'http://' . str_random(20),
            'permalink' => 'http://' . str_random(20),
            'comment' => 'http://' . str_random(20),
            'is_private' => '1',
            'is_read_for_later' => '0',
            'htn_add_datetime' => '2018-01-02 23:59:59',
            'htn_add_date' => '2018-01-02',
            'user_id' => '1',
            'created_at' => '2018-01-01 23:59:59',
            'updated_at' => '2018-01-01 23:59:59',
        ]);
        DB::table('bookmarks')->insert([
            'username' => 'tacck',
            'title' => str_random(10),
            'url' => 'http://' . str_random(20),
            'permalink' => 'http://' . str_random(20),
            'comment' => 'http://' . str_random(20),
            'is_private' => '1',
            'is_read_for_later' => '0',
            'htn_add_datetime' => '2018-01-02 23:59:59',
            'htn_add_date' => '2018-01-02',
            'user_id' => '1',
            'created_at' => '2018-01-01 23:59:59',
            'updated_at' => '2018-01-01 23:59:59',
        ]);
        DB::table('bookmarks')->insert([
            'username' => 'tacck',
            'title' => str_random(10),
            'url' => 'http://' . str_random(20),
            'permalink' => 'http://' . str_random(20),
            'comment' => 'http://' . str_random(20),
            'is_private' => '1',
            'is_read_for_later' => '0',
            'htn_add_datetime' => '2018-01-03 23:59:59',
            'htn_add_date' => '2018-01-03',
            'user_id' => '1',
            'created_at' => '2018-01-01 23:59:59',
            'updated_at' => '2018-01-01 23:59:59',
        ]);
        DB::table('bookmarks')->insert([
            'username' => 'tacck',
            'title' => str_random(10),
            'url' => 'http://' . str_random(20),
            'permalink' => 'http://' . str_random(20),
            'comment' => 'http://' . str_random(20),
            'is_private' => '1',
            'is_read_for_later' => '0',
            'htn_add_datetime' => '2018-01-03 23:59:59',
            'htn_add_date' => '2018-01-03',
            'user_id' => '1',
            'created_at' => '2018-01-01 23:59:59',
            'updated_at' => '2018-01-01 23:59:59',
        ]);
        DB::table('bookmarks')->insert([
            'username' => 'tacck',
            'title' => str_random(10),
            'url' => 'http://' . str_random(20),
            'permalink' => 'http://' . str_random(20),
            'comment' => 'http://' . str_random(20),
            'is_private' => '1',
            'is_read_for_later' => '0',
            'htn_add_datetime' => '2018-01-03 23:59:59',
            'htn_add_date' => '2018-01-03',
            'user_id' => '1',
            'created_at' => '2018-01-01 23:59:59',
            'updated_at' => '2018-01-01 23:59:59',
        ]);
        DB::table('bookmarks')->insert([
            'username' => 'tacck2',
            'title' => str_random(10),
            'url' => 'http://' . str_random(20),
            'permalink' => 'http://' . str_random(20),
            'comment' => 'http://' . str_random(20),
            'is_private' => '1',
            'is_read_for_later' => '0',
            'htn_add_datetime' => '2018-01-01 23:59:59',
            'htn_add_date' => '2018-01-01',
            'user_id' => '2',
            'created_at' => '2018-01-01 23:59:59',
            'updated_at' => '2018-01-01 23:59:59',
        ]);
        DB::table('bookmarks')->insert([
            'username' => 'tacck2',
            'title' => str_random(10),
            'url' => 'http://' . str_random(20),
            'permalink' => 'http://' . str_random(20),
            'comment' => 'http://' . str_random(20),
            'is_private' => '1',
            'is_read_for_later' => '0',
            'htn_add_datetime' => '2018-01-01 23:59:59',
            'htn_add_date' => '2018-01-01',
            'user_id' => '2',
            'created_at' => '2018-01-01 23:59:59',
            'updated_at' => '2018-01-01 23:59:59',
        ]);
    }
}
