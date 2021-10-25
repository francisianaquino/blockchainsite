<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = ['user_id', 'game_id', 'subject', 'description', 'rating', 'screenshots'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function game() {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }
}
