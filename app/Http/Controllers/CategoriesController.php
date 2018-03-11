<?php

namespace App\Http\Controllers;

use App\Category;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category){
        $topics = Topic::where('category_id',$category->id)->paginate(10);
        return view('topics.index',compact('topics','category'));
    }
}
