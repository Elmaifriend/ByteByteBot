<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'name', 'status', 'data', 'created_at', 'updated_at'];

    protected $casts = [
        'data' => 'array',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
