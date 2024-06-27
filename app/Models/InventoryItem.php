<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'type_id',
        'stock',
        'condition_id',
        'unit_id',
        'photo',
        'description',
    ];

    public function type()
    {
        return $this->belongsTo(ItemType::class, 'type_id');
    }

    public function condition()
    {
        return $this->belongsTo(ItemCondition::class, 'condition_id');
    }

    public function unit()
    {
        return $this->belongsTo(ItemUnit::class, 'unit_id');
    }
    
}
