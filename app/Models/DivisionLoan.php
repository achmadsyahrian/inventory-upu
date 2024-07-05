<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_division_id',
        'to_division_id',
        'inventory_item_id',
        'quantity',
        'loan_date',
        'return_date',
        'reason',
        'status',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function fromDivision()
    {
        return $this->belongsTo(Division::class, 'from_division_id');
    }

    public function toDivision()
    {
        return $this->belongsTo(Division::class, 'to_division_id');
    }
    
}
