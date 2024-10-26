<?php

namespace App\Console\Commands;

use App\Models\WhatsappQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class executeWhatsappQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:execute-whatsapp-queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = WhatsappQueue::where(['notified' => false, 'request_notified' => true])->orderBy('transaction_mail_id', 'ASC')->first();
        if (!empty($data)) {
            Artisan::call('app:send-whats-app ' . $data->transaction_mail_id);
            dd(Artisan::output());
        }
    }
}
