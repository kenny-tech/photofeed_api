<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['photo_id', 'user_id', 'posted', 'comment'];
}
