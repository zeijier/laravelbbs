<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //注册数据填充类
    public function run()
    {
        $this->call(UsersTableSeeder::class);
		$this->call(TopicsTableSeeder::class);
        $this->call(ReplysTableSeeder::class);
    }
}
