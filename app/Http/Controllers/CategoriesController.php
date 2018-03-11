<?php

namespace App\Http\Controllers;

use App\Category;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category,Topic $topic,Request $request){
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = $topic->withOrder($request->order)->where('category_id',$category->id)->paginate(3);
//        $topics = Topic::where('category_id',$category->id)->paginate(10);
        return view('topics.index',compact('topics','category'));
    }
}
