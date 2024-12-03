<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\DetailEventSchedule;
use App\Models\EventSchedule;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $totalData = EventSchedule::select('event_schedules.*', 'u.name as admin')
            ->join('users as u', 'u.id', '=', 'event_schedules.user_id')
            ->where([
                [
                    'event_schedules.user_id',
                    ((getRole() == 'Developer') ? '<>' : '='),
                    ((getRole() == 'Developer') ? NULL : auth()->user()->id)
                ],
            ])
            ->orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = EventSchedule::select('event_schedules.*', 'u.name as admin')
                ->join('users as u', 'u.id', '=', 'event_schedules.user_id');

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
            ])->get();
        } else {
            $assets = EventSchedule::select('event_schedules.*', 'u.name as admin')
                ->join('users as u', 'u.id', '=', 'event_schedules.user_id')
                ->where('event_schedules.name', 'ilike', '%' . $request['search']['value'] . '%')
                ->orWhere('date', 'ilike', '%' . $request['search']['value'] . '%')
                ->orWhere('u.name', 'ilike', '%' . $request['search']['value'] . '%')
                ->orWhere('recipient', 'ilike', '%' . $request['search']['value'] . '%');

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
            ])->get();

            $totalFiltered = EventSchedule::select('event_schedules.*', 'u.name as admin')
                ->join('users as u', 'u.id', '=', 'event_schedules.user_id')
                ->where('event_schedules.name', 'ilike', '%' . $request['search']['value'] . '%')
                ->orWhere('date', 'ilike', '%' . $request['search']['value'] . '%')
                ->orWhere('u.name', 'ilike', '%' . $request['search']['value'] . '%')
                ->orWhere('recipient', 'ilike', '%' . $request['search']['value'] . '%');

            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->where([
                [
                    'event_schedules.user_id',
                    ((getRole() == 'Developer') ? '<>' : '='),
                    ((getRole() == 'Developer') ? NULL : auth()->user()->id)
                ],
            ])->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row['index'] = $request['start'] + ($index + 1);
            $row['name'] = $item->name;
            $row['date'] = $item->date;
            $row['recipient'] = $item->recipient;
            $row['admin'] = $item->admin;
            $row['detail_event'] = DetailEventSchedule::where('event_schedule_id', $item->id)->get()->toArray();
            $row['file_attachment'] = "<button title='" . trans('translation.show') . ' ' . trans('translation.event_file_attachment') . "' class='btn btn-icon btn-info file-thumbnails' data-file='" . $item->file_attachment . "'><i class='bx bx-image' ></i></button>";
            $row['action'] = "<button title='Kirim pengumuman' class='btn btn-icon btn-success send-broadcast' data-event='" . $item->id . "' ><i class='bx bxs-paper-plane' ></i></button><button title='Perbaiki pengumuman' data-event='" . $item->id . "' class='btn btn-icon btn-warning maintenance-broadcast'><i class='bx bx-pencil' ></i></button><button title='" . trans('translation.show') . ' ' . trans('translation.timeline') . "' data-event='" . $item->id . "' class='btn btn-icon btn-secondary show-timeline'><i class='bx bx-show' ></i></button>";
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
        $request->validate([
            'name' => 'required|min:5|max:100',
            'date' => 'required|date',
            'recipient' => 'required|min:5|max:50',
            'agendas' => 'required|array',
            'agendas.*.name' => 'required|string|min:5|max:50',
            'agendas.*.time' => 'required',
            'agendas.*.speaker' => 'required|string|min:5|max:50',
            'agendas.*.online' => 'required|string',
            'agendas.*.location' => 'required_if:online,false|string|min:5|max:50',
            'agendas.*.meeting.id' => 'required_if:online,true|string|min:5|max:50',
            'agendas.*.meeting.passcode' => 'required_if:online,true|string|min:5|max:50',
            'agendas.*.meeting.topic' => 'required_if:online,true|string|min:5|max:50',
            'file_attachment.id' => 'required|string',
            'file_attachment.type' => 'required|string|starts_with:image/',
            'file_attachment.size' => 'required|integer|max:' . env('FILE_LIMIT') . '',
            'file_attachment.data' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $data_event = $request->except('_token', 'agendas');
            $data_event['user_id'] = auth()->user()->id;
            if (!empty($data_event['file_attachment'])) {
                $file_name = 'event_file_attachment/' . $data_event['file_attachment']['id'] . '.jpg';
                file_put_contents(public_path($file_name), base64_decode($data_event['file_attachment']['data']));
                $data_event['file_attachment'] = $file_name;
            }
            $event_schedule = EventSchedule::create($data_event);
            $data_agenda = [];
            foreach ($request->only('agendas')['agendas'] as $key => $value) {
                $value['event_schedule_id'] = $event_schedule->id;
                $value['created_at'] = now('Asia/Jakarta');
                $value['updated_at'] = now('Asia/Jakarta');
                if ($value['online'] == 'true') {
                    $value['meeting'] = json_encode([
                        'id' => $value['meeting.id'],
                        'passcode' => $value['meeting.passcode'],
                        'topic' => $value['meeting.passcode']
                    ]);
                    unset($value['meeting.id'], $value['meeting.passcode'], $value['meeting.topic']);
                }
                array_push($data_agenda, $value);
            }
            DetailEventSchedule::insert($data_agenda);
            DB::commit();
            $response = ['message' => 'successfully creating resources'];
            $code = 200;
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = ['message' => 'failed creating resources'];
            $code = 422;
        }
        return response()->json($response, $code);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
