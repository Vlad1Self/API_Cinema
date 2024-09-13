<?php

namespace App\Models;

use App\Enums\Payment\PaymentStatusEnum;
use App\Models\ValueObject\Payment\Amount;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'ticket_id',
        'status',
        'amount',
        'payable_id',
        'driver_payment_id',
        'payable_type',
        'payment_method_id',
    ];

    protected $casts = [
        'status' => PaymentStatusEnum::class,
    ];

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: function($value) {
                $price = new Amount($value);
                return $price->getValue();
            },
        );
    }

    protected static function booted(): void
    {
        static::creating(function ($payment) {
            $payment->uuid = Str::uuid();
        });
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }
}
