<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends User
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'picture',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
