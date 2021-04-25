<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'audio_path', 'delivered',
    ];

    protected $hidden = [
        'user_id', 'audio_path',
    ];

}
