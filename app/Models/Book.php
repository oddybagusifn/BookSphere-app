<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'isbn',
        'published_year',
        'edition',
        'language',
        'page_count',
        'synopsis',
        'cover_url',
        'category_id',
        'is_readable',
        'view_count',
        'rating',
        'rating_count',
    ];

    protected $casts = [
        'is_readable' => 'boolean',
        'published_year' => 'integer',
        'page_count' => 'integer',
        'view_count' => 'integer',
        'rating' => 'float',
        'rating_count' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function getCoverUrlAttribute($value)
    {
        return $value
            ? asset($value)
            : asset('images/default-book.png');
    }

    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating ?? 0, 1);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function updateRatingSummary()
    {
        $this->rating_count = $this->reviews()->count();
        $this->rating = $this->reviews()->avg('rating') ?? 0;
        $this->save();
    }

    public function getAverageRatingAttribute()
{
    return $this->reviews()->avg('rating') ?? 0;
}

}

