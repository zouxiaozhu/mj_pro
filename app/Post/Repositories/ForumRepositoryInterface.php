<?php
namespace App\Post\Repositories;
interface ForumRepositoryInterface{

    /**
     * 创建一个板块
     * @param $data
     * @return mixed
     */
    public function create($data);

    public function findForum($data);

    public function checkTitle($title);

    public function show($data);

    public function delete($ids);
}