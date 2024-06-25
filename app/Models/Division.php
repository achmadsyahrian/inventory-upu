<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'division_head',
        'dimensions',
        'description',
        'condition_id',
        'building_id',
    ];

    public function condition()
    {
        return $this->belongsTo(DivisionCondition::class, 'condition_id');
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

}
