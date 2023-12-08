<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

//    CREATE TABLE chats
//(
//    id          INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
//    sender_id   INT                            NOT NULL,
//    receiver_id INT                            NOT NULL,
//    message     TEXT                           NOT NULL,
//    sent_at     DATETIME                       NOT NULL,
//    status      ENUM ('seen', 'unseen')        NOT NULL DEFAULT 'unseen',
//    created_at  DATETIME                       NOT NULL DEFAULT NOW(),
//    updated_at  DATETIME                       NOT NULL DEFAULT NOW(),
//    FOREIGN KEY (sender_id) REFERENCES users (id),
//    FOREIGN KEY (receiver_id) REFERENCES users (id)
//);

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'sent_at',
        'status'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopeUnseen($query)
    {
        return $query->where('status', 'unseen');
    }

    public function scopeSeen($query)
    {
        return $query->where('status', 'seen');
    }

    public function scopeSentAt($query, $date)
    {
        return $query->where('sent_at', $date);
    }

    public function scopeSender($query, $sender_id)
    {
        return $query->where('sender_id', $sender_id);
    }

    public function scopeReceiver($query, $receiver_id)
    {
        return $query->where('receiver_id', $receiver_id);
    }

    public function scopeMessage($query, $message)
    {
        return $query->where('message', $message);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeCreatedAt($query, $date)
    {
        return $query->where('created_at', $date);
    }

    public function scopeUpdatedAt($query, $date)
    {
        return $query->where('updated_at', $date);
    }

    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeBetween($query, $sender_id, $receiver_id)
    {
        return $query->where('sender_id', $sender_id)->where('receiver_id', $receiver_id)
            ->orWhere('sender_id', $receiver_id)->where('receiver_id', $sender_id);
    }
}
