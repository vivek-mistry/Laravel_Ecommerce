<?php

namespace App\Console\Commands;

use App\Models\StatusType;
use Illuminate\Console\Command;

class MigrateStatusTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:status-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Status Types';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->output->title('Starting Migrate Order Status');
        /**
         * Stage - 1
         * order_status : pending, confirmed, cancelled, shipped, delivered
         * 
         * payment_status:  Success, Failed, Pending
         * 
         * payment_type : Cash, Online
         */
        $order_status = [
            ['status_type' => 'order_status', 'status_name' => 'Pending'],
            ['status_type' => 'order_status', 'status_name' => 'Confirmed'],
            ['status_type' => 'order_status', 'status_name' => 'Cancelled'],
            ['status_type' => 'order_status', 'status_name' => 'Shipped'],
            ['status_type' => 'order_status', 'status_name' => 'Delivered'],

            ['status_type' => 'payment_status', 'status_name' => 'Success'],
            ['status_type' => 'payment_status', 'status_name' => 'Failed'],
            ['status_type' => 'payment_status', 'status_name' => 'Pending'],

            ['status_type' => 'payment_type', 'status_name' => 'Cash'],
            ['status_type' => 'payment_type', 'status_name' => 'Online']
        ];
        $this->output->progressStart(1);
        foreach($order_status as $key => $status)
        {
            StatusType::create($status);
        }
        $this->output->progressFinish();
        $this->output->success('End Order Status Migrate');
        return 0;
    }
}
