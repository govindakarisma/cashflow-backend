<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;

    protected $fillable = ["name", "slug", "when", "amount", "description"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
