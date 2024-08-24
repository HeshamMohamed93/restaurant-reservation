<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Models\Table;
use App\Models\WaitingList;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyWaitingList extends Command
{
    protected $signature = 'notify:waiting-list';
    protected $description = 'Notify customers on the waiting list when a table becomes available';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $availableTables = Table::whereDoesntHave('reservations', function ($query) {
            $query->where('from_time', '<=', now())
                ->where('to_time', '>=', now());
        })->get();

        if ($availableTables->isEmpty()) {
            $this->info('No tables available at this time.');
            return;
        }

        $waitingLists = WaitingList::whereNull('reservation_id')
            ->orderBy('priority', 'asc')
            ->get();

        foreach ($waitingLists as $waitingList) {
            if ($availableTables->isEmpty()) break;

            $customer = $waitingList->customer;
            $table = $availableTables->shift();

            $reservation = Reservation::create([
                'table_id' => $table->id,
                'customer_id' => $waitingList->customer_id,
                'from_time' => Carbon::now()->addMinutes(30),
                'to_time' => Carbon::now()->addMinutes(90),
            ]);

            $waitingList->update([
                'reservation_id' => $reservation->id,
                'priority' => null,
                'notified_at' => now(),
            ]);

            //todo notify using email or SMS service

            $this->info("Notified customer {$customer->name} about table availability.");
        }
    }
}
