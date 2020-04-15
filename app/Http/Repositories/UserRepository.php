<?php

namespace App\Http\Repositories;

use App\User; 

class UserRepository {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($data)
    {
        return $this->user->create($data);
    }

    public function get()
    {
        return $this->user->get();
    }

    public function update_user($user_id, $data)
    {
        return $this->user->where('id', $user_id)->update($data);
    }

    public function get_user($user_id)
    {
        return $this->user->where('id', $user_id)->first();
    }

    public function delete_user($user_id)
    {
        return $this->user->where('id', $user_id)->delete();   
    }

}
