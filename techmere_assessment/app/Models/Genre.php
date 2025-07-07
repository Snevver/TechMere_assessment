<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * The user movies that belong to the genre.
     */
    public function userMovies(): BelongsToMany
    {
        return $this->belongsToMany(UserMovie::class);
    }
}
