<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\Api\V1\ProductResource;
use DB;
use Validator;
use Hash;
use Log;

class ApiController extends Controller
{

    public function accessToken(Request $request)
    {
        $errors = [];
        $error = false;

        $validate = $this->validations($request, "login");
 
        if($validate["error"]){
            return $this->prepareResult(false, [], $validate['errors'],"Error while validating user");
        }
        $user = User::where("email",$request->email)->first();
 
        if($user){
            if (Hash::check($request->password,$user->password)) {
                return $this->prepareResult(true, ["accessToken" => $user->createToken('Todo App')->accessToken], [],"User Verified");
            }else{
                return $this->prepareResult(false, [], ["password" => "Wrong passowrd"],"Password not matched");  
            }
        }else{
            return $this->prepareResult(false, [], ["email" => "Unable to find user"],"User not found");
        }
    }

    private function prepareResult($status, $data, $errors, $message)
    {
        return ['status' => $status,'data'=> $data,'message' => $message,'errors' => $errors];
    }

    public function validations($request,$type)
    {
        $errors = [];
        $error = false;
        if($type == "login") {
            $validator = Validator::make($request->all(),[
            'email' => 'required|email|max:255',
            'password' => 'required',
            ]);
            if($validator->fails()){
                $error = true;
                $errors = $validator->errors();
            }
        }
        return ["error" => $error,"errors"=>$errors];
    }

}
