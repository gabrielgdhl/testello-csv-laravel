<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_postcode',
        'to_postcode',
        'from_weight',
        'to_weight',
        'cost',
        'client_id'
    ];
}
