<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    public function skilltree(): BelongsTo
    {
        return $this->belongsTo(Skilltree::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class, 'parent_id');
    }

    public function parentSkill(): BelongsTo
    {
        $this->belongsTo(Skill::class, 'parent_id');
    }
}
