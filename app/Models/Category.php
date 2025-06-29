<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function booksPaginated($perPage = 4)
    {
        return $this->hasMany(Book::class)->paginate($perPage);
    }
}
