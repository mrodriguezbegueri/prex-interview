<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    
    protected $fillable = [
        'user_id',
        'service',
        'body_request',
        'http_code',
        'body_response',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
