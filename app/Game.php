<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'description',
        'image',
        'genre',
        'blockchain',
        'device',
        'status',
        'nft',
        'f2p',
        'p2e',
        // 'p2e_score',
        'is_approved'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'game_id', 'id');
    }
}
