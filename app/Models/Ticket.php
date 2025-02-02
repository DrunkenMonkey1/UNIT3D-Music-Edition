<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function strtotime;

class Ticket extends Model
{
    use HasFactory;
    use Auditable;

    protected $casts = [
        'closed_at'   => 'datetime',
        'reminded_at' => 'datetime',
    ];

    public function scopeStatus($query, $status)
    {
        if ($status === 'all') {
            return $query;
        }

        if ($status === 'closed') {
            return $query->whereNotNull('closed_at');
        }

        if ($status === 'open') {
            return $query->whereNull('closed_at');
        }
    }

    public function scopeStale($query)
    {
        return $query->with(['comments' => function ($query) {
            $query->latest('id');
        }, 'comments.user'])
            ->has('comments')
            ->where('reminded_at', '<', strtotime('+ 3 days'))
            ->orWhereNull('reminded_at');
    }

    public static function checkForStaleTickets(): void
    {
        $open_tickets = self::status('open')
            ->whereNotNull('staff_id')
            ->get();

        foreach ($open_tickets as $open_ticket) {
            Comment::checkForStale($open_ticket);
        }
    }

    /**
     * Belongs To A User (Created).
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'username' => 'System',
            'id'       => '1',
        ]);
    }

    /**
     * Belongs To A Staff User (Assigned).
     */
    public function staff(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Belongs To A Ticket Priority.
     */
    public function priority(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TicketPriority::class);
    }

    /**
     * Belongs To A Ticket Category.
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TicketCategory::class);
    }

    /**
     * Has Many Ticket Attachments.
     */
    public function attachments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TicketAttachment::class);
    }

    /**
     * Has Many Comments.
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
