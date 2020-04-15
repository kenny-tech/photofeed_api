<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CommentRepository;
use Illuminate\Http\Request;
use DB;

class CommentController extends Controller
{
    private $comment;

    public function __construct (CommentRepository $comment)
    {
        $this->comment = $comment;
    }

    public function create(Request $request)
    {
        $data = [
            'photo_id' => $request->photo_id,
            'user_id' => $request->user_id,
            'posted' => $request->posted,
            'comment' => $request->comment,
        ];
        // start database transaction
        DB::beginTransaction();

        try {
            $comment = $this->comment->create($data);
            DB::commit();
            return $this->sendSuccess($comment, 'success');
        }
        catch(\Exception $e) {
            DB::rollback();
            return $this->sendError($comment=[], $e->getMessage());
        }
    }

    public function get()
    {
        try {
            $comment = $this->comment->get();
            return $this->sendSuccess($comment, 'success');
        }
        catch(\Exception $e) {
            return $this->sendError($comment=[], $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $comment_id = $request->comment_id;

            // check if comment exists
            $check_comment = $this->comment->get_comment($comment_id);
            if($check_comment==null) {
                return $this->sendError($comment=[], 'comment ID '.$comment_id. ' does not exist');
            }

            $data = $request->except(['comment_id']);
            $update_comment = $this->comment->update_comment($comment_id, $data);
            DB::commit();

            $comment = $this->comment->get_comment($comment_id);
            return $this->sendSuccess($comment, 'success');
        }
        catch(\Exception $e) {
            DB::rollback();
            return $this->sendError($comment=[], $e->getMessage());
        }
    }

    public function getOne($comment_id)
    {
        try {
            // check if comment exists
            $check_comment = $this->comment->get_comment($comment_id);
            if($check_comment==null) {
                return $this->sendError($comment=[], 'comment ID '.$comment_id. ' does not exist');
            }
            
            $comment = $this->comment->get_comment($comment_id);
            return $this->sendSuccess($comment, 'success');
        }
        catch(\Exception $e) {
            return $this->sendError($comment=[], $e->getMessage());
        }
    }

    public function delete($comment_id)
    {
        // start database transaction
        DB::beginTransaction();

        try {
            // check if comment exists
            $check_comment = $this->comment->get_comment($comment_id);
            if($check_comment==null) {
                DB::commit();
                return $this->sendError($comment=[], 'comment ID '.$comment_id. ' does not exist');
            }

            $comment = $this->comment->delete_comment($comment_id);
            return $this->sendSuccess($comment=[], 'success');
        }
        catch(\Exception $e) {
            DB::rollback();
            return $this->sendError($comment=[], $e->getMessage());
        }
    }

}
