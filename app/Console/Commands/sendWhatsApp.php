<?php

namespace App\Console\Commands;

use App\Models\TransactionMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class sendWhatsApp extends Command
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
        $data = TransactionMail::select('transaction_mails.*', 'wq.notified', 'wq.request_notified', 'wq.current_status')
            ->join('whatsapp_queues as wq', 'transaction_mails.id', '=', 'wq.transaction_mail_id')
            ->with('admin', 'agenda', 'type', 'priority')->where([['notified', false], ['request_notified', true]])
            ->orderBy('wq.transaction_mail_id', 'ASC')
            ->find($this->argument('transaction_mail_id'))
            ->toArray();
        $data['sender_phone_number'] = unFormattedPhoneNumber($data['sender_phone_number']);
        if ($data['current_status'] == 'ALERT') {
            $registered = Http::get(env('WHATSAPP_URL') . 'phone-check/' . unFormattedPhoneNumber($data['admin']['phone_number']));
            $code = 301;
            if (intval($registered->status()) <= 300) {
                $response = Http::post(env('WHATSAPP_URL') . 'mail-status/' . unFormattedPhoneNumber($data['admin']['phone_number']) . '/' . $data['current_status'], [
                    'sender' => $data['sender'],
                    'number' => $data['number'],
                    'admin' => $data['admin']['name'],
                    'agenda' => $data['agenda']['name'],
                    'type' => $data['type']['name'],
                    'priority' => $data['priority']['name'],
                ]);
                $code = $response->status();
            } else {
                $code = 200;
            }
        } else if ($data['current_status'] == 'IN' || $data['current_status'] == 'REPLIED') {
            $response = Http::attach(
                'file_attachment',
                file_get_contents(public_path(($data['current_status'] == 'IN') ? $data['file_attachment'] : $data['reply_file_attachment'])),
                $data['regarding'] . '.pdf'
            )->post(env('WHATSAPP_URL') . 'mail-status/' . $data['sender_phone_number'] . '/' . $data['current_status'], [
                'sender' => $data['sender'],
                'number' => $data['number'],
                'admin' => $data['admin']['name'],
                'agenda' => $data['agenda']['name'],
                'type' => $data['type']['name'],
                'priority' => $data['priority']['name'],
            ]);
            $code = $response->status();
        } else {
            $response = Http::post(env('WHATSAPP_URL') . 'mail-status/' . $data['sender_phone_number'] . '/' . $data['current_status'], [
                'sender' => $data['sender'],
                'number' => $data['number'],
                'admin' => $data['admin']['name'],
                'agenda' => $data['agenda']['name'],
                'type' => $data['type']['name'],
                'priority' => $data['priority']['name'],
            ]);
            $code = $response->status();
        }
        if ($code == 200) {
            $this->info('Notified Mail Sender Successfully');
        } else {
            $this->error('Failed Notified Mail Sender');
        }
    }
}
