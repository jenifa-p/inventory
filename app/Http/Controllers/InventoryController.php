<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LowStockAlert;
use App\Models\User;
use App\Models\InventoryItem;
use App\Models\InventoryAction;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        if($request->get('search') != "") {
            $term = $request->get('search');
            $inventoryItems = InventoryItem::where('name', 'like', "%$term%")
            ->orWhere('description', 'like', "%$term%")
            ->get();
        }else{
            $inventoryItems = InventoryItem::all();
        }
        return view('inventory.index', compact('inventoryItems'));
    }

    public function trackingindex()
    {
        if(Auth::user()->hasRole('super-admin')){
            $inventoryactions = InventoryAction::all();
            return view('inventorytrack.index', compact('inventoryactions'));
        }else{
            return "Page not available";
        }

    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'quantity_in_stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'inventory_level' => 'required'
        ]);

        $inventoryItem = InventoryItem::create($request->all());

        InventoryAction::create([
            'user_id' => Auth::id(),
            'inventory_item_id' => $inventoryItem->id,
            'quantity' => $inventoryItem->quantity_in_stock,
            'action' => $inventoryItem->inventory_level
        ]);

        return redirect()->route('inventoryindex')->with('success', 'Inventory item created successfully.');
    }

    public function edit(InventoryItem $inventory)
    {
        return view('inventory.edit', compact('inventory'));
    }

    public function update(Request $request, InventoryItem $inventory)
    {
        $request->validate([
            'name' => 'required',
            'quantity_in_stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'inventory_level' => 'required'
        ]);

        $existinginventory = InventoryItem::find($inventory->id);

        $inventory->update($request->all());

        if($inventory->inventory_level == 'received') {
            if($existinginventory->quantity_in_stock != $inventory->quantity_in_stock){
                $inventory->increaseStock($inventory->quantity_in_stock);
            }
            $action = 'receive';
        } elseif($inventory->inventory_level == 'sold') {
            $inventory->decreaseStock($inventory->quantity_in_stock);
            $action = 'sell';
        }

        InventoryAction::create([
            'user_id' => Auth::id(),
            'inventory_item_id' => $inventory->id,
            'quantity' => $inventory->quantity_in_stock,
            'action' => $action,
        ]);

        return redirect()->route('inventoryindex')->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(InventoryItem $inventory)
    {
        InventoryAction::create([
            'user_id' => Auth::id(),
            'inventory_item_id' => $inventory->id,
            'action' => 'deleted'
        ]);

        $inventory->delete();

        return redirect()->route('inventoryindex')->with('success', 'Inventory item deleted successfully.');
    }

    public function export()
    {
        $path = storage_path('app/public/inventories.csv');

        $writer = SimpleExcelWriter::create($path);

        $writer->addRow([
            'Name', 
            'Description', 
            'Quantity in Stock', 
            'Inventory Level',
            'Price'
        ]);

        InventoryItem::all()->each(function ($inventory) use ($writer) {
            $writer->addRow([
                'name' => $inventory->name,
                'description' => $inventory->description,
                'quantity_in_stock' => $inventory->quantity_in_stock,
                'inventory_level' => $inventory->inventory_level,
                'price' => $inventory->price,
            ]);
        });

        return response()->download($path);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv'
        ]);

        $path = $request->file('file')->store('temp');
        $file = storage_path('app/' . $path);

        SimpleExcelReader::create($file)->getRows()->each(function (array $row) {
            Inventory::updateOrCreate(
                ['name' => $row['name']],
                [
                    'description' => $row['description'],
                    'quantity_in_stock' => $row['quantity_in_stock'],
                    'inventory_level' => $row['inventory_level'],
                    'price' => $row['price'],
                ]
            );
        });

        return redirect()->route('inventoryindex')->with('success', 'Inventory data imported successfully.');
    }

}
