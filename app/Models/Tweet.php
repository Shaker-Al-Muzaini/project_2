<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{

    use HasFactory;
    protected $hidden = ['likes', 'user'];
    protected $fillable = ['content', 'user_id'];
    protected $with = ['user_likes'];
    protected $appends = ['likes_count'];
    public  function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public  function likes()
    {
        return $this->hasMany(Like::class, 'tweet_id', 'id');
    }
    public  function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    public  function user_likes()
    {
        return $this->hasManyThrough(
            User::class,
            Like::class,
            'tweet_id',
            'id',
            'id',
            'user_id',
        );
    }

    public function scopeSearch()
    {
    }
    public function scopeSort()
    {
    }
}
