<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Likes extends Model
{
    use HasFactory;

    protected  $table = "likes";
    protected $fillable = [
        'user_id',
        'post_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function likeable()
    {
        return $this->morphTo(); // Get the Post that this like is related to.
    }
}
