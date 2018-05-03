<?php

namespace App\Models;

class MtLog extends Model
{
    protected $fillable = ['api', 'request', 'response', 'type'];
}
