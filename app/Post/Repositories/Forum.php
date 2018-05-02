<?php
namespace App\Post\Repositories;
use App\Post\Models\ForumModel;
use Carbon\Carbon;

class Forum implements ForumRepositoryInterface{
    public function create($data){
        $forum = ForumModel::create($data);
        $forum->order_id = $forum->id;
        // 更新父亲的childs_id
        $father_forum = ForumModel::find($data['fid']);
        if($father_forum){
            $father_forum->      childs_id = $father_forum->childs_id.",{$forum->id}";
            $forum->fathers_id = $father_forum->id.",{$father_forum->fathers_id}";
            $father_forum->save();
        }
        $forum->save();
        return $forum;
    }

    public function checkTitle($title)
    {
        $count = ForumModel::where('title',$title)->count();
        return $count;
    }

    public function findForum($data)
    {
        // TODO: Implement findForum() method.
    }

    public function show($data)
    {
        $forum_model = ForumModel::where('id', '>', 0);
        if ($data['start_time']) {
            $forum_model = $forum_model->where('start_time', '>', Carbon::createFromTimestamp($data['start_time'])->toDateTimeString());
        }
        if ($data['end_time']) {
            $forum_model = $forum_model->where('start_time', '>', Carbon::createFromTimestamp($data['start_time'])->toDateTimeString());
        }
        if($data['post_max_num']>0){
            $forum_model = $forum_model->where('post_num','>',$data['post_max_num']);
        }
        $offset = ($data['page']-1)*$data['per_num'];
        $forum_model = $forum_model->where('post_num','>=',$data['post_min_num'])->take($data['per_num'])->skip($offset)->get();
        return $forum_model->toArray();
    }

    public function delete($ids)
    {
        $ids = explode(',',$ids);
        $forum_model = ForumModel::destroy($ids);
    }
}