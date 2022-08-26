<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemInOut extends Model
{
    use HasFactory;
    protected $fillable = ['item_id','qty','item_transaction_type'];
}
