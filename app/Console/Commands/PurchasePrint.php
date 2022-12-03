<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PurchaseOrder;

class PurchasePrint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:purchase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muestras los nombres de los items de las ordenes de compra';

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
        $items = PurchaseOrder::find(1)->itemOrders;
        // dd($pur->itemOrders);
        foreach ($items as $item) {
            echo $item->item->name. PHP_EOL;
        }
        return 0;
    }
}
