<?php

namespace App\Http\Repositories;

use App\Photo; 

class PhotoRepository {

    protected $photo;

    public function __construct(Photo $photo)
    {
        $this->photo = $photo;
    }

    public function create($data){
        return $this->photo->create($data);
    }

    public function get()
    {
        return $this->photo->get();
    }

    public function update_photo($photo_id, $data)
    {
        return $this->photo->where('id', $photo_id)->update($data);
    }

    public function get_photo($photo_id)
    {
        return $this->photo->where('id', $photo_id)->first();
    }

    public function delete_photo($photo_id)
    {
        return $this->photo->where('id', $photo_id)->delete();   
    }

}
