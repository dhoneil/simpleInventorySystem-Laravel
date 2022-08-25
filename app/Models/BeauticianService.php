<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeauticianService extends Model
{
    use HasFactory;
    protected $fillable = ['beautician_id', 'service_id'];
}
