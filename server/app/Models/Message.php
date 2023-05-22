<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'project_id',
        'message'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($message) {
            if(Auth::check()) {
                $message->sender_id = Auth::user()->id;
            }
        });
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
