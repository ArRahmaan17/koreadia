<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EventSchedule;
use App\Models\TransactionMail;

class HomeController extends Controller
{
    public function index()
    {
        $countIn = TransactionMail::whereNotIn('status', ['OUT', 'ARCHIVE'])->count();
        $countOut = TransactionMail::where('status', 'OUT')->count();
        $countProcess = TransactionMail::whereNotIn('status', ['IN', 'OUT', 'ARCHIVE'])->count();
        $countArchive = TransactionMail::where('status', 'ARCHIVE')->count();
        $eventHighlights = EventSchedule::where('date', '>', now(env('APP_TIMEZONE'))->addDay(-1)->format('Y-m-d'))->limit(10)->get();
        return view('index', compact('countIn', 'countOut', 'countProcess', 'countArchive', 'eventHighlights'));
    }
}
