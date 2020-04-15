<?php

namespace App\Http\Controllers;

use App\Http\Repositories\PhotoRepository;
use Illuminate\Http\Request;
use DB;

class PhotoController extends Controller
{
    private $photo;

    public function __construct (photoRepository $photo)
    {
        $this->photo = $photo;
    }

    public function create(Request $request)
    {
        $data = [
            'user_id' => $request->user_id,
            'caption' => $request->caption,
            'posted' => $request->posted,
            'url' => $request->url,
        ];
        // start database transaction
        DB::beginTransaction();

        try {
            $photo = $this->photo->create($data);
            DB::commit();
            return $this->sendSuccess($photo, 'success');
        }
        catch(\Exception $e) {
            DB::rollback();
            return $this->sendError($photo=[], $e->getMessage());
        }
    }

    public function get()
    {
        try {
            $photo = $this->photo->get();
            return $this->sendSuccess($photo, 'success');
        }
        catch(\Exception $e) {
            return $this->sendError($photo=[], $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $photo_id = $request->photo_id;

            // check if photo exists
            $check_photo = $this->photo->get_photo($photo_id);
            if($check_photo==null) {
                return $this->sendError($photo=[], 'photo ID '.$photo_id. ' does not exist');
            }

            $data = $request->except(['photo_id']);
            $update_photo = $this->photo->update_photo($photo_id, $data);
            DB::commit();

            $photo = $this->photo->get_photo($photo_id);
            return $this->sendSuccess($photo, 'success');
        }
        catch(\Exception $e) {
            DB::rollback();
            return $this->sendError($photo=[], $e->getMessage());
        }
    }

    public function getOne($photo_id)
    {
        try {
            // check if photo exists
            $check_photo = $this->photo->get_photo($photo_id);
            if($check_photo==null) {
                return $this->sendError($photo=[], 'photo ID '.$photo_id. ' does not exist');
            }
            
            $photo = $this->photo->get_photo($photo_id);
            return $this->sendSuccess($photo, 'success');
        }
        catch(\Exception $e) {
            return $this->sendError($photo=[], $e->getMessage());
        }
    }

    public function delete($photo_id)
    {
        // start database transaction
        DB::beginTransaction();

        try {
            // check if photo exists
            $check_photo = $this->photo->get_photo($photo_id);
            if($check_photo==null) {
                DB::commit();
                return $this->sendError($photo=[], 'photo ID '.$photo_id. ' does not exist');
            }
            $photo = $this->photo->delete_photo($photo_id);
            return $this->sendSuccess($photo=[], 'success');
        }
        catch(\Exception $e) {
            DB::rollback();
            return $this->sendError($photo=[], $e->getMessage());
        }
    }

}
