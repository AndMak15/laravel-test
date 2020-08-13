<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    const NOT_SEND = 0;
    const SEND = 1;
    const SEND_MONEY = 2;

    protected $fillable = ['type', 'id_user', 'is_send', 'data_type'];
}
