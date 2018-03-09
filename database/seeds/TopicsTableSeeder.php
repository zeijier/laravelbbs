<?php

use App\Category;
use App\User;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        $user_ids = User::all()->pluck('id')->toArray();
        $category_ids = Category::all()->pluck('id')->toArray();
        // 获取Faker 实例
        $faker = app(Faker\Generator::class);
        $topics = factory(Topic::class)->times(10)->make()->each(function ($topic,$index)use($user_ids,$category_ids,$faker){
            // 从用户 ID 数组中随机取出一个并赋值
            $topic->user_id = $faker->randomElement($user_ids);

            // 话题分类，同上
            $topic->category_id = $faker->randomElement($category_ids);
        });
        // 将数据集合转换为数组，并插入到数据库中 要使用 use App\Category; 这种形式。。才能toArray().....
        Topic::insert($topics->toArray());
    }

}

