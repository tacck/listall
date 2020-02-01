<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'tacck',
            'email' => 'gray.tk@gmail.com',
            'password' => bcrypt('tacck'),
            'htn_webhook_token' => 'CE6P73XQ0JPBCT3M',
        ]);
        DB::table('users')->insert([
            'name' => 'tacck2',
            'email' => 'gray.tk+2@gmail.com',
            'password' => bcrypt('tacck2'),
            'htn_webhook_token' => '',
        ]);

        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => str_random(10),
                'email' => str_random(10) . '@gmail.com',
                'password' => bcrypt('secret'),
                'htn_webhook_token' => str_random(200),
            ]);
        }
    }
}
