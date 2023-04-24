<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Crypt;


class CustomApi extends Controller
{
    
    public function __construct()
    {
        //  $this->middleware('auth');
        
    }
    public function register(Request $request)
    {
        $response = [];
        $response['status'] = FALSE;
        $response['message'] = 'Registarion Failed';

        $validation = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);
        if($validation->fails())
        {
            $messages = $validation->errors();
            if ($messages->has('username')) {
                $response['message'] = $messages->get('username')[0] ?? 'Enter Username';
            }
            else if ($messages->has('email')) {
                $response['message'] = $messages->get('email')[0] ?? 'Enter Email';
            }
            else if ($messages->has('password')) {
                $response['message'] = $messages->get('password')[0] ?? 'Enter Password';
            }
            return response()->json($response ,200);
            exit;
        }  
        $data['username']   = $request->input('username');
        $data['email']      = $request->input('email');
        $data['password']   = Crypt::encrypt($request->input('password'));
        $data['api_token']  = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));



        $id =  DB::table('users')->insertGetId($data);
    
        if($id)
        {
            $response['status']  = TRUE;
            $response['message'] = 'Registarion completed successfully!!';
        }
        return response()->json($response ,200);

    }

    public function get_userslist($user_id = '')
    {
        $getQuery = "SELECT * FROM users ";
        if(!empty($user_id) && is_numeric($user_id))
        {
            $getQuery .= "WHERE id =".$user_id;
        }
        $data['userList'] = DB::select($getQuery);
        return view('users_list',$data);
    }

    public function create_user()
    {

        return view('add_user');
    }

    public function update(Request $request)
    {
        $response = [];
        $response['status'] = FALSE;
        $response['message'] = 'Failed to update';

        $validation = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'id' => 'required',
        ]);
        if($validation->fails())
        {
            $messages = $validation->errors();
            if ($messages->has('username')) {
                $response['message'] = $messages->get('username')[0] ?? 'Enter Username';
            }
            else if ($messages->has('email')) {
                $response['message'] = $messages->get('email')[0] ?? 'Enter Email';
            }
            else if ($messages->has('id')) {
                $response['message'] = $messages->get('id')[0] ?? 'Id required';
            }
            return response()->json($response ,200);
            exit;
        }  
        $data['username']   = $request->input('username');
        $data['email']      = $request->input('email');
        $data['id']      = $request->input('id');

        $updateQuery = "UPDATE users SET username = '".$data['username']."' , email = '".$data['email']."' WHERE id = ".$data['id'];
        $resp =  DB::update($updateQuery);
    
        if($resp)
        {
            $response['status']  = TRUE;
            $response['message'] = 'Details updated successfully!!';
        }
        return response()->json($response ,200);

    }

    public function delete(REQUEST $request)
    {
        $id          = $request->input('id');
        $deleteQuery = " DELETE FROM users WHERE id = ".$id;
        $resp = DB::delete($deleteQuery);

        $response['status']  = TRUE;
        $response['message'] = 'Record deleted successfully!!';
        return response()->json($response ,200);

    }
}
