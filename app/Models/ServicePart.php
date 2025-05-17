<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePart extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'part_type', 'amount'];


    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
