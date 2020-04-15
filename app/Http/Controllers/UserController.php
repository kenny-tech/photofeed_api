<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;

class UserController extends Controller
{
    private $user;

    public function __construct (UserRepository $user)
    {
        $this->user = $user;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error ', $validator->errors());
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'avatar' => $request->avatar,
        ];
        // start database transaction
        DB::beginTransaction();

        try {
            $user = $this->user->create($data);
            DB::commit();
            return $this->sendSuccess($user, 'success');
        }
        catch(\Exception $e) {
            DB::rollback();
            return $this->sendError($user=[], $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                return $this->sendSuccess(Auth::user(), 'success');
            }
            else{
                return $this->sendError($user=[], 'Invalid Email/Password');
            }
        }
        catch(\Exception $e) {
            return $this->sendError($user=[], $e->getMessage());
        }
    }

    public function get()
    {
        try {
            $user = $this->user->get();
            return $this->sendSuccess($user, 'success');
        }
        catch(\Exception $e) {
            return $this->sendError($user=[], $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $user_id = $request->user_id;

            // check if user exists
            $check_user = $this->user->get_user($user_id);
            if($check_user==null) {
                return $this->sendError($user=[], 'user ID '.$user_id. ' does not exist');
            }

            $data = $request->except(['user_id']);
            $update_user = $this->user->update_user($user_id, $data);
            DB::commit();

            $user = $this->user->get_user($user_id);
            return $this->sendSuccess($user, 'success');
        }
        catch(\Exception $e) {
            DB::rollback();
            return $this->sendError($user=[], $e->getMessage());
        }
    }

    public function getOne($user_id)
    {
        try {
            // check if user exists
            $check_user = $this->user->get_user($user_id);
            if($check_user==null) {
                return $this->sendError($user=[], 'user ID '.$user_id. ' does not exist');
            }
            
            $user = $this->user->get_user($user_id);
            return $this->sendSuccess($user, 'success');
        }
        catch(\Exception $e) {
            return $this->sendError($user=[], $e->getMessage());
        }
    }

    public function delete($user_id)
    {
        // start database transaction
        DB::beginTransaction();

        try {
            // check if user exists
            $check_user = $this->user->get_user($user_id);
            if($check_user==null) {
                DB::commit();
                return $this->sendError($user=[], 'user ID '.$user_id. ' does not exist');
            }

            $user = $this->user->delete_user($user_id);
            return $this->sendSuccess($user=[], 'success');
        }
        catch(\Exception $e) {
            DB::rollback();
            return $this->sendError($user=[], $e->getMessage());
        }
    }

}
