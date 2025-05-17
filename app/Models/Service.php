<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['customer', 'phone', 'chasis', 'km', 'bay', 'charge', 'type', 'date', 'time', 'image'];

    public function parts(): HasMany
    {
        return $this->hasMany(ServicePart::class);
    }
}
