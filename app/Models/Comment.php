<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    public function post() //post_id
    {
        return $this->belongsTo(Post::class);
    }

    public function author() // author_id
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
