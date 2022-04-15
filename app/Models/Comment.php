<?php

namespace App\Models;

use App\Models\Interfaces\Likeable;
use App\Models\Traits\Likes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model implements Likeable
{
    use HasFactory, Likes;

    protected  $table = "comments";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'post_id',
        'content',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'posted_at'
    ];

    /**
     * Return the comment's author
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Return the comment's post
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

}
