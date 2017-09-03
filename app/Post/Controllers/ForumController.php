<?php
namespace App\Post\Controllers;

use App\Http\Controllers\Controller;
use App\Post\Repositories\ForumRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{
    protected $forum;

    protected $order_field = ['order_id','id','created_time','updated_time'];
    public function __construct(ForumRepositoryInterface $forum)
    {
        $this->forum = $forum;
        //$this->middleware();
    }

    public function create()
    {
        $check = $this->checkValidate(request()->all());
        if (!is_array($check)) {
            return $check;
        }
        if (request()->has('fid')) {
            $father_forum = $this->forum->findForum(request('fid'));
        }
        $insert = [
            'title' => trim($check['title']),
            'fid' => request('fid', 0),
            'brief' => trim(request('brief', '')),
            'create_user_id' => auth()->user()->id,
            'indexpic' => request('indexpic', 0),
            'is_last' => 1,
            'is_hot' => 0,
            'is_close' => 1,
            'fathers_id' =>isset($father_forum) ? $father_forum['fathers_id'] : '',
            'childs_id' => '',
            'order_id' => 0,
        ];
        $count = $this->forum->checkTitle($insert['title']);
        if($count){
            return myerror('1002','title already exist');
        }
        $ret = $this->forum->create($insert);
        return mysuccess($ret);
    }

    public function show(){
       $data = [
                'page'     => request('page',1),
                'per_num'  => request('per_num',10),
                'start_time' => request('start_time',0),
                'end_time' => intval(request('end_time',0)),
                'order_type' => trim(request('order_type','DESC')),
                'order_field' => trim(request('order_field','order_id')),
                'post_min_num' => intval(request('post_min_num_',0)),
                'post_max_num' =>intval(request('post_max_num',0))
              ];

        $forum_list = $this->forum->show($data);
        return mysuccess($forum_list);
    }

    protected function checkValidate($request)
    {
        $fill_able = [
            'title' => 'required',
        ];
        $message = [
            'title.required' => 'NO Title',
        ];

        $validate = Validator::make($request, $fill_able, $message);
        if ($validate->fails()) {
            return myerror(10000, $validate->errors()->first());
        }
        return $request;
    }

    public function delete()
    {
        $ids = request('id',0);
        if(!$ids){
            return myerror(1004,'no Id');
        }
        $ret = $this->forum->delete(trim($ids));
        return mysuccess($ids);
    }

}