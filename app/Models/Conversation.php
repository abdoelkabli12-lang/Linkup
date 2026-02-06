<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'user_one',
        'user_two'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function otherUser($authId)
    {
        return $this->user_one === $authId ? $this->user_two : $this->user_one;
    }
}
