<?php

namespace App\Console\Commands;

use App\Models\EventSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class sendBroadcastEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-broadcast-event {event_schedule_id}';

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
        $data = EventSchedule::with('agendas')->select('event_schedules.*', 'e.phone_number')
            ->join('event_queues as eq', 'event_schedules.id', '=', 'eq.event_schedule_id')
            ->join('employees as e', 'event_schedules.user_id', '=', 'e.id')
            ->where([['eq.broadcast', false], ['eq.request_broadcast', true]])->orderBy('eq.event_schedule_id', 'ASC')->find($this->argument('event_schedule_id'))->toArray();
        $data['phone_number'] = unFormattedPhoneNumber($data['phone_number']);
        $response = Http::attach(
            'file_attachment',
            file_get_contents(public_path($data['file_attachment'])),
            $data['name'] . '.jpg'
        )->post(env('WHATSAPP_URL') . 'broadcast-event/' . $data['phone_number'], [
            'name' => $data['name'],
            'date' => Carbon::createFromFormat('Y-m-d', $data['date'], 'Asia/Jakarta')->format('l, j F Y'),
            'recipient' => $data['recipient'],
            'agendas' => json_encode($data['agendas'])
        ]);
        if ($response->status() == 200) {
            $this->info('Notified employee to join event successfully');
        } else {
            $this->error('Failed notified employee to join event');
        }
    }
}
