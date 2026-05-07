<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingPlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'status',
    ];

    /**
     * Reserva a la que pertenece la invitación.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Usuario invitado.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
