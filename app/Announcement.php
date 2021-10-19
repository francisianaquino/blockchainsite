<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';

    protected $fillable = ['id', 'user_id', 'title', 'message'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
