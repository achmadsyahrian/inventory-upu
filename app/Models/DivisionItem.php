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

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function division() 
    {
        return $this->belongsTo(Division::class);
    }
    
}
