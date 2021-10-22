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
        'is_approved'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'game_id', 'id');
    }

    public function rating() {
        $total_rating = 0;
        foreach($this->reviews()->get() as $review) {
            $total_rating += $review->rating;
        }

        if ($this->reviews()->count() > 0) {
            $average_rating = $total_rating / $this->reviews()->count();
        }
        else {
            $average_rating = 0;
        }

        return round($average_rating, 1);
    }
}
