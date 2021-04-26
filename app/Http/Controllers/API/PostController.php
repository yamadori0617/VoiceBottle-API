<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;


class PostController extends BaseController
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audio_path' => 'max:80',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $audio_path = $request->input('audio_path');
        $user_id = $request->input('user_id');
        $post = Post::create([
            'user_id' => $user_id,
            'audio_path' => $audio_path,
        ]);

        $success['id'] = $post['id'];
        $success['user_id'] = $post['user_id'];
        $success['audio_path'] = $post['audio_path'];
        $success['delivered'] = $post['delivered'];
        //$posts = Post::all();

        return $this->sendResponse($success, "Post successfully.");
    }
}
