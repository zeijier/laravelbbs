<?php

namespace App\Http\Controllers;

use App\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        //除了 index() 和 show() 以外的方法使用 auth 中间件进行认证。
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request,Topic $topic)
	{
	    //$request->order 是获取 URI http://xxxx/topics?order=recent 中的 order 参数。
	    $topics = $topic->withOrder($request->order)->paginate(3);
//	    with()提前加载了后面需要用到的关联属性user 和 category，并做缓存。（这里的user和category是topic模型里面定义的方法）
//		$topics = Topic::with(['user','category'])->paginate(5);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
	    $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
	    // fill() 给eloquent实例赋值属性的方法
        //fill 方法会将传参的键值数组填充到模型的属性中
	    $topic->fill($request->all());
	    $topic->user_id = Auth::id();
	    $topic->save();
		return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
}