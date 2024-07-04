<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_item_id',
        'division_id',
        'quantity',
    ];
    
}
