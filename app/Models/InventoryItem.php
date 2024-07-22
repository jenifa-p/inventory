<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'quantity_in_stock', 
        'price',
        'low_stock_threshold',
        'inventory_level'
    ];

    public function increaseStock($quantity)
    {
        $this->quantity_in_stock += $quantity;
        $this->save();
    }

    public function decreaseStock($quantity)
    {
        if ($this->quantity_in_stock >= $quantity) {
            $this->quantity_in_stock -= $quantity;
            $this->save();
        } else {
            throw new \Exception('Not enough stock to fulfill the request.');
        }
    }

    public function isLowStock()
    {
        return $this->quantity_in_stock < $this->low_stock_threshold;
    }

    public function inventorytracking()
    {
        return $this->hasMany(InventoryAction::class);
    }
}
