<?php

namespace App\Models;

use App\Enums\Social\SocialDriverEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Social extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'driver',
        'driver_user_id',
    ];

    protected $casts = [
        'driver' => SocialDriverEnum::class,
    ];

    protected static function booted(): void
    {
        static::creating(function ($ticket) {
            $ticket->uuid = Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
