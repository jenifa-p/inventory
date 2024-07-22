<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InventoryItem;
use App\Notifications\LowStockAlert;
use Illuminate\Support\Facades\Notification;

class CheckLowStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:check-low-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for low stock items and send notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $lowStockItems = InventoryItem::all()->filter->isLowStock();

        if ($lowStockItems->isNotEmpty()) {
            Notification::route('mail', 'jenifaece1@gmail.com')->notify(new LowStockAlert($lowStockItems));
            $this->info('Low stock alerts sent.');
        } else {
            $this->info('No low stock items found.');
        }
        return 0;
    }
}
