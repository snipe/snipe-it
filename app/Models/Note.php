<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Note extends Model
{
    /**
     * Get the parent item of a comment
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}

