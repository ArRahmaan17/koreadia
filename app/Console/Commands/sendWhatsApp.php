<?php

namespace App\Console\Commands;

use App\Models\TransactionMail;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class sendWhatsApp extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-whats-app {transaction_mail_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail tracking whatsapp message to mail sender';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = TransactionMail::with('admin', 'agenda', 'type', 'priority')->find($this->argument('transaction_mail_id'))->toArray();
        $data['sender_phone_number'] = unFormattedPhoneNumber($data['sender_phone_number']);
        $response = Http::attach(
            'file_attachment',
            file_get_contents(public_path($data['file_attachment'])),
            $data['regarding'] . '.pdf',
        )->post(env('WHATSAPP_URL') . 'mail-status/' . $data['sender_phone_number'] . '/' . $data['status'], ['sender' => $data['sender']]);
        if ($response->accepted()) {
            $this->info('Notified Mail Sender Successfully');
        } else {
            $this->error("Failed Notified Mail Sender");
        }
    }
}
