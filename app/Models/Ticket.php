<?php

namespace App\Models;

use App\Enums\Ticket\TicketStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'seat',
        'status',
        'movie_id'
    ];

    protected $casts = [
        'status' => TicketStatusEnum::class
    ];

    protected static function booted(): void
    {
        static::creating(function ($ticket) {
            $ticket->uuid = Str::uuid();
        });
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
