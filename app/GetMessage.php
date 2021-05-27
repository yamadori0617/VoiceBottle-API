<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class GetMessage extends Model
{
    protected $fillable = [
        'id', 'from_id',
    ];

    protected $hidden = [
        'id', 'from_id',
    ];

}
