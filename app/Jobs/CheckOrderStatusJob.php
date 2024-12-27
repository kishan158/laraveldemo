<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Order;
use App\Models\VendorOrder;

class CheckOrderStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $vendorOrder;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     * @param VendorOrder $vendorOrder
     */
    public function __construct(Order $order, VendorOrder $vendorOrder)
    {
        $this->order = $order;
        $this->vendorOrder = $vendorOrder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log the job processing
        Log::info('Checking order status for order: ' . $this->order->order_id);
    
        // Reload the order to get the latest status
        $this->order->refresh();
    
        if ($this->order->status === 'Pending') {
            // If still 'Pending', revert the status and delete associated VendorOrder
            $this->order->Order_status = 'Awaiting';
            $this->order->save();
    
            // Log the change
            Log::info('Order status reverted to Awaiting for order: ' . $this->order->order_id);
    
            $this->vendorOrder->delete();
        }
    }
}
