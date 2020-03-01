<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobLog extends Model
{
    protected $fillable = ['id', 'result', 'type', 'status'];
    public $timestamps = false;
}
