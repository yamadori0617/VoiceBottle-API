<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use ErrorException;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'max:30',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $name = $request->input('name');
        $password = strval($this->randomPassword());
        $api_token = Str::random(60);

        try {
            if ($name == null) {
                $user = User::create([
                    'password' => $password,
                    'api_token' => $api_token,
                ]);
                $user['name'] = "匿名さん";
            } else {
                $user = User::create([
                    'name' => $name,
                    'password' => $password,
                    'api_token' => $api_token,
                ]);    
            }
    
        } catch (ErrorException $e) {
            return $this->sendError('Query Error');
        }

        $success['id'] = $user['id'];
        $success['password'] = $user['password'];
        $success['name'] = $user['name'];
        $success['api_token'] = $user['api_token'];

        return $this->sendResponse($success, "User register successfully.");
    }

    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }     
}
