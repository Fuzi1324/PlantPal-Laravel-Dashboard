<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{

    use HasFactory;

    protected $fillable = ['user_id', 'installation_code',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
