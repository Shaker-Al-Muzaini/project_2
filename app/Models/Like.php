<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }
    public function scopeSearch()
    {
    }
    public function scopeSort()
    {
    }
}
