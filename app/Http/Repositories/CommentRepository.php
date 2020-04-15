<?php

namespace App\Http\Repositories;

use App\Comment; 

class CommentRepository {

    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function create($data){
        return $this->comment->create($data);
    }

    public function get()
    {
        return $this->comment->get();
    }

    public function update_comment($comment_id, $data)
    {
        return $this->comment->where('id', $comment_id)->update($data);
    }

    public function get_comment($comment_id)
    {
        return $this->comment->where('id', $comment_id)->first();
    }

    public function delete_comment($comment_id)
    {
        return $this->comment->where('id', $comment_id)->delete();   
    }

}
