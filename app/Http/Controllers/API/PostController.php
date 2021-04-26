<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audio_path' => 'max:80',
            'from_id' => 'max:50',
            'to_id' => 'nullable|max:200',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $audio_path = $request->input('audio_path');
        $from_id = $request->input('from_id');
        $to_id = $request->input('to_id');

        if (is_null($to_id)) {
            $to_id = $to_id = DB::select('SELECT id FROM users WHERE id <> ? 
                                          ORDER BY RAND() LIMIT 1', [$from_id])[0]->id;
        }

        $post = Post::create([
            'from_id' => $from_id,
            'to_id' => $to_id,
            'audio_path' => $audio_path,
        ]);


        $success['id'] = $post['id'];
        $success['from_id'] = $post['from_id'];
        $success['audio_path'] = $post['audio_path'];
        $success['delivered'] = $post['delivered'];
        //$posts = Post::all();

        return $this->sendResponse($success, "Post successfully.");
    }
}
