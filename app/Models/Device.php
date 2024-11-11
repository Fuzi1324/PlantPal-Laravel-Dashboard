<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{

    use HasFactory;

    protected $fillable = ['user_id', 'device_id', 'application_id', 'name'];

    public function installation()
    {
        return $this->belongsTo(Installation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
