<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class, 'parent_id');
    }
}
