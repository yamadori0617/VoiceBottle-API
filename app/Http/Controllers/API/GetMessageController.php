<?php

namespace App\Http\Controllers\API;

use App\Post;
use App\Http\Controllers\API\BaseController as BaseController;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class GetMessageController extends BaseController
{
    public function get_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|max:100',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $api_token = $request->input('api_token');
        
        try {
            $user_id = DB::select('SELECT id FROM users WHERE api_token = ?', [$api_token])[0]->id;
            $message = DB::select('SELECT * FROM posts
                                   WHERE created_at = (
                                        SELECT MIN(created_at) FROM `posts` 
                                        WHERE to_id = ?
                                        AND delivered = false) 
                                   AND to_id = ?', [$user_id, $user_id])[0];

            $success["id"] = $message->id;
            $success["from_id"] = $message->from_id;
            $success["audio_path"] = $message->audio_path;
            $success["sender_name"] = DB::select('SELECT name FROM users WHERE id = ?',[$message->from_id])[0]->name;

            DB::beginTransaction();
            DB::update('UPDATE posts SET delivered = true WHERE id = :message_id', ['message_id' => $message->id]); 
            DB::commit();

        } catch (ErrorException $ex) {
            return $this->sendError('Query Error');
        }

        return $this->sendResponse($success, "Post successfully.");
    }
}
