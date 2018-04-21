<?php

namespace App\Http\Controllers;

use App\Category;
use App\Handlers\ImageUploadHandler;
use App\Models\Link;
use App\Models\Topic;
use App\User;
use Faker\Provider\Image;
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

	public function index(Request $request,Topic $topic,Link $link)
	{

	    //$request->order 是获取 URI http://xxxx/topics?order=recent 中的 order 参数。
	    $topics = $topic->withOrder($request->order)->paginate(20);
//	    with()提前加载了后面需要用到的关联属性user 和 category，并做缓存。（这里的user和category是topic模型里面定义的方法）
//		$topics = Topic::with(['user','category'])->paginate(5);
        $user = new  User();
        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();
		return view('topics.index', compact('topics','active_users','links'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
//	    $this->authorize('');
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
		return redirect()->route('topics.show', $topic->id)->with('message', '创建成功');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories  = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', '更新成功');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', '删除成功');
	}
	public function uploadImage(Request $request,ImageUploadHandler $upload){
        //初始化返回数据，默认是失败的
        $data = [
            'success'=>false,
            'msg'=>'上传失败！',
            'file_path'=>''
        ];
        //判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file){
            //保存图片到本地
            $result = $upload->save($request->upload_file,'topics',Auth::id(),1024);
            // 图片保存成功的话
            if ($result){
                $data['file_path']=$result['path'];
                $data['msg']='上传成功';
                $data['success'] = true;
            }
        }
        return $data;
    }
}