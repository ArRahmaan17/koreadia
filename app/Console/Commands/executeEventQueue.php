<?php

namespace App\Console\Commands;

use App\Models\EventQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class executeEventQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:execute-event-queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'worker for whatsapp event broadcast';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = EventQueue::where(['broadcast' => false, 'request_broadcast' => true])->orderBy('id', 'ASC')->first();
        if (! empty($data)) {
            Artisan::call('app:send-broadcast-event ' . $data->id);
            if (trim(Artisan::output()) == 'Notified employee to join event successfully') {
                dd(EventQueue::find($data->id)->update(['broadcast' => true, 'broadcasted_at' => now(env('APP_TIMEZONE'))]));
            }
        }
    }
}
