<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\EventSchedule;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

class EventScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('event');
    }
    public function dataTable(Request $request)
    {
        $totalData = EventSchedule::select('event_schedules.*', 'u.name as admin', 'ma.name as agenda', 'mp.name as priority', 'mt.name as type', 'wq.notified', 'wq.request_notified', 'wq.user_id as processor_id')->join('mail_agendas as ma', 'ma.id', '=', 'event_schedules.agenda_id')
            ->join('mail_priorities as mp', 'mp.id', '=', 'event_schedules.priority_id')
            ->join('mail_types as mt', 'mt.id', '=', 'event_schedules.type_id')
            ->join('users as u', 'u.id', '=', 'event_schedules.user_id')
            ->leftJoin('whatsapp_queues as wq', function (JoinClause $join) {
                $join->on('event_schedules.id', '=', 'wq.transaction_mail_id')
                    ->on('event_schedules.status', '=', 'wq.current_status');
            })
            ->where([
                [
                    'event_schedules.user_id',
                    ((getRole() == 'Developer') ? '<>' : '='),
                    ((getRole() == 'Developer') ? NULL : auth()->user()->id)
                ],
                ['event_schedules.status', '!=', 'OUT']
            ])->where(function ($query) {
                $query->where('wq.user_id', auth()->user()->id)
                    ->orWhere('event_schedules.creator_id', auth()->user()->id);
            })
            ->orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = EventSchedule::select('event_schedules.*', 'u.name as admin', 'ma.name as agenda', 'mp.name as priority', 'mt.name as type', 'wq.notified', 'wq.request_notified', 'wq.user_id as processor_id')->join('mail_agendas as ma', 'ma.id', '=', 'event_schedules.agenda_id')
                ->join('mail_priorities as mp', 'mp.id', '=', 'event_schedules.priority_id')
                ->join('mail_types as mt', 'mt.id', '=', 'event_schedules.type_id')
                ->join('users as u', 'u.id', '=', 'event_schedules.user_id')
                ->leftJoin('whatsapp_queues as wq', function (JoinClause $join) {
                    $join->on('event_schedules.id', '=', 'wq.transaction_mail_id')
                        ->on('event_schedules.status', '=', 'wq.current_status');
                });

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            $assets = $assets->where([
                [
                    'event_schedules.user_id',
                    ((getRole() == 'Developer') ? '<>' : '='),
                    ((getRole() == 'Developer') ? NULL : auth()->user()->id)
                ],
                ['event_schedules.status', '!=', 'OUT']
            ])->where(function ($query) {
                $query->where('wq.user_id', auth()->user()->id)
                    ->orWhere('event_schedules.creator_id', auth()->user()->id);
            })->get();
        } else {
            $assets = EventSchedule::select('event_schedules.*', 'u.name as admin', 'ma.name as agenda', 'mp.name as priority', 'mt.name as type', 'wq.notified', 'wq.request_notified', 'wq.user_id as processor_id')
                ->join('mail_agendas as ma', 'ma.id', '=', 'event_schedules.agenda_id')
                ->join('mail_priorities as mp', 'mp.id', '=', 'event_schedules.priority_id')
                ->join('mail_types as mt', 'mt.id', '=', 'event_schedules.type_id')
                ->join('users as u', 'u.id', '=', 'event_schedules.user_id')
                ->leftJoin('whatsapp_queues as wq', function (JoinClause $join) {
                    $join->on('event_schedules.id', '=', 'wq.transaction_mail_id')
                        ->on('event_schedules.status', '=', 'wq.current_status');
                })
                ->where('number', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('regarding', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('date', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('sender', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('sender_phone_number', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('file_attachment', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('status', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('date_in', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('u.name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('ma.name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('mp.name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('mt.name', 'like', '%' . $request['search']['value'] . '%');

            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->where([
                [
                    'event_schedules.user_id',
                    ((getRole() == 'Developer') ? '<>' : '='),
                    ((getRole() == 'Developer') ? NULL : auth()->user()->id)
                ],
                ['event_schedules.status', '!=', 'OUT']
            ])->where(function ($query) {
                $query->where('wq.user_id', auth()->user()->id)
                    ->orWhere('event_schedules.creator_id', auth()->user()->id);
            })->get();

            $totalFiltered = EventSchedule::select('event_schedules.*', 'u.name as admin', 'ma.name as agenda', 'mp.name as priority', 'mt.name as type', 'wq.notified', 'wq.request_notified', 'wq.user_id as processor_id')
                ->join('mail_agendas as ma', 'ma.id', '=', 'event_schedules.agenda_id')
                ->join('mail_priorities as mp', 'mp.id', '=', 'event_schedules.priority_id')
                ->join('mail_types as mt', 'mt.id', '=', 'event_schedules.type_id')
                ->join('users as u', 'u.id', '=', 'event_schedules.user_id')
                ->leftJoin('whatsapp_queues as wq', function (JoinClause $join) {
                    $join->on('event_schedules.id', '=', 'wq.transaction_mail_id')
                        ->on('event_schedules.status', '=', 'wq.current_status');
                })
                ->where('number', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('regarding', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('date', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('sender', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('sender_phone_number', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('file_attachment', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('status', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('date_in', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('u.name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('ma.name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('mp.name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('mt.name', 'like', '%' . $request['search']['value'] . '%');

            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->where([
                [
                    'event_schedules.user_id',
                    ((getRole() == 'Developer') ? '<>' : '='),
                    ((getRole() == 'Developer') ? NULL : auth()->user()->id)
                ],
                ['event_schedules.status', '!=', 'OUT']
            ])->where(function ($query) {
                $query->where('wq.user_id', auth()->user()->id)
                    ->orWhere('event_schedules.creator_id', auth()->user()->id);
            })->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row['index'] = $request['start'] + ($index + 1);
            $row['number'] = $item->number;
            $row['regarding'] = $item->regarding;
            $row['date'] = $item->date;
            $row['sender'] = $item->sender;
            $row['sender_phone_number'] = $item->sender_phone_number;
            if ($item->reply_file_attachment == NULL) {
                $row['file_attachment'] = "<button class='btn btn-icon btn-info file' data-file='" . $item->file_attachment . "'><i class='bx bxs-file-pdf' ></i></button>";
            } else {
                $row['file_attachment'] = "<button class='btn btn-icon btn-info file' data-file='" . $item->reply_file_attachment . "'><i class='bx bxs-file-pdf' ></i></button>";
            }
            $row['status'] = $item->status;
            $row['date_in'] = $item->date_in;
            $row['admin'] = $item->admin;
            $row['agenda'] = $item->agenda;
            $row['priority'] = $item->priority;
            $row['type'] = $item->type;
            if ((getRole() == 'Developer' || $item->creator_id == auth()->user()->id) && $item->notified && ($item->status == 'REPLIED' || $item->status == 'OUT')) {
                $row['action'] = "<button class='btn btn-icon btn-warning update-status' data-mailsIn='" . $item->id . "' ><i class='bx bx-check-double'></i></button>";
            } else if ((getRole() == 'Developer' || $item->user_id == auth()->user()->id) && $item->notified && ($item->status != 'REPLIED' && $item->status != 'OUT' && $item->status != 'ARCHIVE')) {
                $row['action'] = "<button class='btn btn-icon btn-info update-status' data-mailsIn='" . $item->id . "' ><i class='bx bxs-chevrons-up'></i></button><button class='btn btn-icon btn-warning edit' data-mailsIn='" . $item->id . "' ><i class='bx bx-pencil' ></i></button><button data-mailsIn='" . $item->id . "' class='btn btn-icon btn-danger delete'><i class='bx bxs-trash-alt' ></i></button>";
            } else if ((getRole() == 'Developer' || $item->processor_id == auth()->user()->id) && $item->status != 'ARCHIVE' && $item->request_notified == false && $item->notified == false) {
                $row['action'] = "<button class='btn btn-icon btn-success request-notify' data-mailsIn='" . $item->id . "' ><i class='bx bxl-whatsapp'></i></button>";
            } else if (($item->creator_id == auth()->user()->id && $item->status != 'ARCHIVE') || ($item->request_notified == true && $item->notified == false)) {
                $row['action'] = "<button class='btn btn-icon btn-secondary disabled' data-mailsIn='" . $item->id . "' ><i class='bx bx-loader-circle' ></i></button>";
            } else {
                $row['action'] = "<button class='btn btn-icon btn-info show' data-mailsIn='" . $item->id . "' ><i class='bx bxs-show'></i></button><button class='btn btn-icon btn-success print-report' data-mailsIn='" . $item->id . "' ><i class='bx bxs-printer'></i></button>";
            }
            $dataFiltered[] = $row;
        }
        $response = [
            'draw' => $request['draw'],
            'recordsFiltered' => $totalFiltered,
            'recordsTotal' => count($dataFiltered),
            'aaData' => $dataFiltered,
        ];

        return Response()->json($response, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
