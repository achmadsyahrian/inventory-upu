<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'inventory_item_id',
        'requester_name',
        'quantity',
        'status'
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    // For Notification
    public static function countPendingRequests()
    {
        return self::where('status', 'pending')->count();
    }
    
}
