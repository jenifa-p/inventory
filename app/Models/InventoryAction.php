<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'inventory_item_id', 
        'quantity',
        'action'
    ];

    public function inventory()
    {
        return $this->belongsTo(InventoryItem::class,'inventory_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
