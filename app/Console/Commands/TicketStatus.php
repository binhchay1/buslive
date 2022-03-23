<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;

class TicketStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Status for Ticket';

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
        $query = DB::table('trips')->where('date', '<=', date('Y-m-d'))->get();
        foreach ($query as $row) {
            $fullTime = $row->date . ' ' . $row->start . ':00';
            if (strtotime($fullTime) < strtotime(date('Y-m-d H:i:s'))) {
                $getTicket = DB::table('ticket')->where('trips_id', $row->id)->get();
                foreach ($getTicket as $record) {
                    if ($record->status == 3) {
                        continue;
                    }
                    $ticket = new Ticket();
                    $ticket->where('id', $record->id)->update(['status' => '1']);
                }
            }
        }
    }
}
