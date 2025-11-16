<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'amount',
        'is_recurring',
        'completed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_recurring' => 'boolean',
        'completed_at' => 'datetime'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check apakah note sudah completed di bulan ini
     */
    public function isCompletedThisMonth()
    {
        if (!$this->completed_at) {
            return false;
        }

        $currentMonth = Carbon::now()->format('Y-m');
        $completedMonth = Carbon::parse($this->completed_at)->format('Y-m');

        return $currentMonth === $completedMonth;
    }

    /**
     * Scope untuk filter by month
     */
    public function scopeForMonth($query, $yearMonth)
    {
        return $query->whereYear('completed_at', '=', Carbon::parse($yearMonth)->year)
                     ->whereMonth('completed_at', '=', Carbon::parse($yearMonth)->month);
    }
}
