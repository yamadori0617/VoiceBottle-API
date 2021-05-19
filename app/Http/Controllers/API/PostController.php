<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController as BaseController;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audio_path' => 'required|max:100',
            'to_id' => 'nullable|max:50',
            'api_token' => 'required|max:100',
            'audio_content' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $audio_path = $request->input('audio_path');
        $to_id = $request->input('to_id');
        $api_token = $request->input('api_token');
        $audio_content = $request->input('audio_content');

        try {
            $from_id = DB::select('select id from users where api_token = ?', [$api_token])[0]->id;

            if (is_null($to_id)) {
                $to_id = DB::select('SELECT id FROM users WHERE id <> ? 
                                              ORDER BY RAND() LIMIT 1', [$from_id])[0]->id;
            }
    
            $post = Post::create([
                'from_id' => $from_id,
                'to_id' => $to_id,
                'audio_path' => $audio_path,
            ]);

            DB::update('update users set sent_counts = sent_counts + 1 where id = ?', [$from_id]);
            DB::update('update users set received_counts = received_counts + 1 where id = ?', [$to_id]);

            //$save_file_path = storage_path().$audio_path
            //Storage::prepend($save_file_path, $content);
            \Storage::prepend($audio_path, $audio_content);
            
            $success['id'] = $post['id'];
            $success['from_id'] = $post['from_id'];
            $success['audio_path'] = $post['audio_path'];
            $success['delivered'] = $post['delivered'];
            //$posts = Post::all();
    
        } catch (ErrorException $e) {
            return $this->sendError('Query Error');
        }

        return $this->sendResponse($success, "Post successfully.");
    }
}
