<?php

namespace App\Http\Controllers;

use App\Category;
use App\Models\Topic;
use App\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category,Topic $topic,Request $request,User $user){
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = $topic->withOrder($request->order)->where('category_id',$category->id)->paginate(20);
//        $topics = Topic::where('category_id',$category->id)->paginate(10);

        // 活跃用户列表
        $active_users = $user->getActiveUsers();
        return view('topics.index',compact('topics','category','active_users'));
    }
}
