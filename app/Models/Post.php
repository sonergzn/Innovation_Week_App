<?php

namespace App\Models;

use App\Models\Interfaces\Likeable;
use App\Models\likes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected  $table = "posts";

    protected $fillable = ['title', 'content', 'slug', 'posted_at', 'published', 'author_id', 'image_path'];

    /**
     * @var array
     */
    protected $dates = [
        'posted_at'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }


    public function isAuthor($author): bool
    {
        return $this->author()->first()->name == $author->name;
     }

    public function isPublished(): bool
    {
        return filled($this->published);
    }

    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'thumbnail_id');
    }

    public function comments(): HasMany
    {
        return $this->HasMany(Comment::class)->orderBy('posted_at', 'DESC');
    }

    public function invites(): HasMany
    {
        return $this->HasMany(Invite::class);
    }

    public function hasThumbnail(): bool
    {
        return filled($this->thumbnail_id);
    }

    public function likes(){
        return $this->hasMany(likes::class);
    }

    public function likedBy(User $user){
        return $this->likes()->where('user_id', $user->id)->first();
    }

    public function editors(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'posts_users',
            'post_id',
            'editor_id');
    }

    public function hasEditor($email): bool
    {
        foreach ($this->editors()->get()->push($this->author()->first()) as $editor) {
            if ($editor->email == $email){
                return true;
            }
        }
        return false;
    }
}
