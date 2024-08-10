<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function division() 
    {
        return $this->belongsTo(Division::class);
    }

    public function condition()
    {
        return $this->belongsTo(ItemCondition::class, 'condition_id');
    }
    
}
