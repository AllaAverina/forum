<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;

class Topic extends Model
{
    use HasFactory, SoftDeletes, Prunable;

    /**
     * Get the posts for the topic.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the user that owns the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the prunable model query.
     */
    public function prunable()
    {
        return static::where('deleted_at', '<=', now()->subDays(3));
    }

    /**
     * Prepare the model for pruning.
     */
    protected function pruning()
    {
        foreach ($this->posts() as $post) {
            $post->comments()->delete();
        }
        $this->posts()->delete();
    }
}
