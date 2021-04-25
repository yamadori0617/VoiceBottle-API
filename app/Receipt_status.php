<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Receipt_status extends Model
{
    protected $fillable = [
        'id', 'from_id', 'latest_audio_path',
    ];

    protected $hidden = [
        'id', 'from_id', 'latest_audio_path',
    ];

}
