<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\TransactionMail;
use App\Models\WhatsappQueue;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MailTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mail');
    }

    public function dataTable(Request $request)
    {
        $totalData = TransactionMail::select('transaction_mails.*', 'u.name as admin', 'ma.name as agenda', 'mp.name as priority', 'mt.name as type', 'wq.notified', 'wq.request_notified')->join('mail_agendas as ma', 'ma.id', '=', 'transaction_mails.agenda_id')
            ->join('mail_priorities as mp', 'mp.id', '=', 'transaction_mails.priority_id')
            ->join('mail_types as mt', 'mt.id', '=', 'transaction_mails.type_id')
            ->join('users as u', 'u.id', '=', 'transaction_mails.user_id')
            ->leftJoin('whatsapp_queues as wq', function (JoinClause $join) {
                $join->on('transaction_mails.id', '=', 'wq.transaction_mail_id')
                    ->on('transaction_mails.status', '=', 'wq.current_status');
            })
            ->orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = TransactionMail::select('transaction_mails.*', 'u.name as admin', 'ma.name as agenda', 'mp.name as priority', 'mt.name as type', 'wq.notified', 'wq.request_notified')->join('mail_agendas as ma', 'ma.id', '=', 'transaction_mails.agenda_id')
                ->join('mail_priorities as mp', 'mp.id', '=', 'transaction_mails.priority_id')
                ->join('mail_types as mt', 'mt.id', '=', 'transaction_mails.type_id')
                ->join('users as u', 'u.id', '=', 'transaction_mails.user_id')
                ->leftJoin('whatsapp_queues as wq', function (JoinClause $join) {
                    $join->on('transaction_mails.id', '=', 'wq.transaction_mail_id')
                        ->on('transaction_mails.status', '=', 'wq.current_status');
                });

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = TransactionMail::select('transaction_mails.*', 'u.name as admin', 'ma.name as agenda', 'mp.name as priority', 'mt.name as type', 'wq.notified', 'wq.request_notified')
                ->join('mail_agendas as ma', 'ma.id', '=', 'transaction_mails.agenda_id')
                ->join('mail_priorities as mp', 'mp.id', '=', 'transaction_mails.priority_id')
                ->join('mail_types as mt', 'mt.id', '=', 'transaction_mails.type_id')
                ->join('users as u', 'u.id', '=', 'transaction_mails.user_id')
                ->leftJoin('whatsapp_queues as wq', function (JoinClause $join) {
                    $join->on('transaction_mails.id', '=', 'wq.transaction_mail_id')
                        ->on('transaction_mails.status', '=', 'wq.current_status');
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
            $assets = $assets->get();

            $totalFiltered = TransactionMail::select('transaction_mails.*', 'u.name as admin', 'ma.name as agenda', 'mp.name as priority', 'mt.name as type', 'wq.notified', 'wq.request_notified')
                ->join('mail_agendas as ma', 'ma.id', '=', 'transaction_mails.agenda_id')
                ->join('mail_priorities as mp', 'mp.id', '=', 'transaction_mails.priority_id')
                ->join('mail_types as mt', 'mt.id', '=', 'transaction_mails.type_id')
                ->join('users as u', 'u.id', '=', 'transaction_mails.user_id')
                ->leftJoin('whatsapp_queues as wq', function (JoinClause $join) {
                    $join->on('transaction_mails.id', '=', 'wq.transaction_mail_id')
                        ->on('transaction_mails.status', '=', 'wq.current_status');
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
                $totalFiltered->orderByRaw($request['order'][0]['name'] . ' ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
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
                $row['file_attachment'] = "<button class='btn btn-icon btn-info file' data-file='" . $item->file_attachment . "'><i class='bx bxs-printer' ></i></button>";
            } else {
                $row['file_attachment'] = "<button class='btn btn-icon btn-info file' data-file='" . $item->reply_file_attachment . "'><i class='bx bxs-printer' ></i></button>";
            }
            $row['status'] = $item->status;
            $row['date_in'] = $item->date_in;
            $row['admin'] = $item->admin;
            $row['agenda'] = $item->agenda;
            $row['priority'] = $item->priority;
            $row['type'] = $item->type;
            if ($item->notified && ($item->status == 'REPLIED' || $item->status == 'OUT')) {
                $row['action'] = "<button class='btn btn-icon btn-warning update-status' data-mailsIn='" . $item->id . "' ><i class='bx bx-check-double'></i></button>";
            } else if ($item->notified && ($item->status != 'REPLIED' && $item->status != 'OUT' && $item->status != 'ARCHIVE')) {
                $row['action'] = "<button class='btn btn-icon btn-info update-status' data-mailsIn='" . $item->id . "' ><i class='bx bxs-chevrons-up'></i></button><button class='btn btn-icon btn-warning edit' data-mailsIn='" . $item->id . "' ><i class='bx bx-pencil' ></i></button><button data-mailsIn='" . $item->id . "' class='btn btn-icon btn-danger delete'><i class='bx bxs-trash-alt' ></i></button>";
            } else if ($item->request_notified == true && $item->notified == false) {
                $row['action'] = "<button class='btn btn-icon btn-secondary disabled' data-mailsIn='" . $item->id . "' ><i class='bx bx-loader-circle' ></i></button>";
            } else if ($item->status != 'ARCHIVE' && $item->request_notified == false && $item->notified == false) {
                $row['action'] = "<button class='btn btn-icon btn-success request-notify' data-mailsIn='" . $item->id . "' ><i class='bx bxl-whatsapp'></i></button>";
            } else {
                $row['action'] = "<button class='btn btn-icon btn-info show' data-mailsIn='" . $item->id . "' ><i class='bx bxs-show'></i></button>";
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
        $request->validate([
            'number' => 'required|unique:transaction_mails,number|regex:/[0-9]{1,10}\/[A-Z a-z]{2,10}\/[A-Z a-z]{2,4}\/[0-9]{4}/i|min:14|max:32',
            'regarding' => 'required|string|min:5|max:50',
            'agenda_id' => 'required|numeric',
            'priority_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'date' => 'required|Date',
            'sender' => 'required|string|min:5|max:50',
            'sender_phone_number' => 'required|min:18|max:19',
            'file_attachment' => 'required',
            'file_attachment.type' => 'end_with:pdf',
            'file_attachment.type' => 'integer|size:52428800',
            'file_attachment.name' => 'end_with:pdf',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token', 'file_attachment', 'admin');
            $data['date_in'] = now('Asia/Jakarta');
            $data['user_id'] = auth()->user()->id;
            $data['creator_id'] = auth()->user()->id;
            $data['status'] = 'IN';
            if ($request->has('file_attachment')) {
                $file_attachment = json_decode($request->file_attachment);
                $file_name = 'file_attachment/' . $file_attachment->id . '.pdf';
                file_put_contents(public_path($file_name), base64_decode($file_attachment->data));
                $data['file_attachment'] = $file_name;
            }
            $transaction_mail = TransactionMail::create($data);
            $data_queue = ['transaction_mail_id' => $transaction_mail->id, 'current_status' => 'IN', 'user_id' => auth()->user()->id];
            WhatsappQueue::create($data_queue);
            DB::commit();
            $response = ['message' => 'creating resources successfully'];
            $code = 200;
        } catch (\Throwable $th) {
            $response = ['message' => 'failed creating resources'];
            $code = 422;
            DB::rollBack();
        }
        return response()->json($response, $code);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = ['message' => 'showing resources successfully', 'data' => TransactionMail::find($id)];
        $code = 200;
        if (empty(TransactionMail::find($id))) {
            $response = ['message' => 'failed showing resources', 'data' => TransactionMail::find($id)];
            $code = 404;
        }
        return response()->json($response, $code);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'number' => 'required|unique:transaction_mails,number,' . $id . '|regex:/[0-9]{1,10}\/[A-Z a-z]{2,10}\/[A-Z a-z]{2,4}\/[0-9]{4}/i|min:14|max:32',
            'regarding' => 'required|string|min:5|max:50',
            'agenda_id' => 'required|numeric',
            'priority_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'date' => 'required|Date',
            'sender' => 'required|string|min:5|max:50',
            'sender_phone_number' => 'required|min:18|max:19',
            'status' => 'required',
            'file_attachment' => 'string',
            'file_attachment.type' => 'end_with:pdf',
            'file_attachment.type' => 'integer|size:52428800',
            'file_attachment.name' => 'end_with:pdf',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token', 'file_attachment', 'admin');
            if ($request->has('file_attachment')) {
                $file_attachment = json_decode($request->file_attachment);
                $file_name = 'file_attachment/' . $file_attachment->id . '.pdf';
                file_put_contents(public_path($file_name), base64_decode($file_attachment->data));
                $data['file_attachment'] = $file_name;
            }
            $current_status = TransactionMail::find($id);
            TransactionMail::find($id)->update($data);
            switch ($current_status->status) {
                case 'IN':
                    if ($data['status'] == 'PROCESS') {
                        $where_queue = [['transaction_mail_id', NULL]];
                        $data_queue = ['transaction_mail_id' => $current_status->id, 'current_status' => $data['status'], 'last_status' => $current_status->status, 'created_at' => now('Asia/Jakarta'), 'updated_at' => now('Asia/Jakarta'), 'user_id' => auth()->user()->id];
                    } else if ($data['status'] == 'FILED') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    } else if ($data['status'] == 'DISPOSITION') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    } else if ($data['status'] == 'REPLIED') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    }
                    WhatsappQueue::where($where_queue)->delete();
                    WhatsappQueue::insert($data_queue);
                    break;
                case 'PROCESS':
                    if ($data['status'] == 'FILED') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN']];
                        $data_queue =
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'FILED',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ];
                    } else if ($data['status'] == 'DISPOSITION') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN'], ['current_status', '!=', 'PROCESS']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    } else if ($data['status'] == 'REPLIED') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN'], ['current_status', '!=', 'PROCESS']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    }
                    WhatsappQueue::where($where_queue)->delete();
                    WhatsappQueue::insert($data_queue);
                    break;
                case 'FILED':
                    if ($data['status'] == 'DISPOSITION') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', NULL]];
                        $data_queue =
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'DISPOSITION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ];
                    } else if ($data['status'] == 'REPLIED') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN'], ['current_status', '!=', 'PROCESS'], ['current_status', '!=', 'FILED']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    }
                    WhatsappQueue::where($where_queue)->delete();
                    WhatsappQueue::insert($data_queue);
                    break;
                case 'DISPOSITION':
                    $where_queue = [['transaction_mail_id', NULL]];
                    if ($data['status'] == 'REPLIED') {
                        $data_queue =
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => $data['status'],
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ];
                    }
                    WhatsappQueue::where($where_queue)->delete();
                    WhatsappQueue::insert($data_queue);
                    break;
                case 'REPLIED':
                    $where_queue = [['transaction_mail_id', NULL]];
                    $data_queue = [
                        'transaction_mail_id' => $current_status->id,
                        'request_notified' => true,
                        'request_notified_at' => now('Asia/Jakarta'),
                        'current_status' =>  'ARCHIVE',
                        'last_status' => $current_status->status,
                        'created_at' => now('Asia/Jakarta'),
                        'updated_at' => now('Asia/Jakarta'),
                        'user_id' => auth()->user()->id
                    ];
                    WhatsappQueue::where($where_queue)->delete();
                    WhatsappQueue::insert($data_queue);
                    break;
                default:
                    break;
            }
            DB::commit();
            $response = ['message' => 'updating resources successfully'];
            $code = 200;
        } catch (\Throwable $th) {
            $response = ['message' => 'failed updating resources'];
            $code = 422;
            DB::rollBack();
        }
        return response()->json($response, $code);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            TransactionMail::find($id)->delete();
            WhatsappQueue::find($id)->delete();
            DB::commit();
            $response = ['message' => 'destroying resources successfully'];
            $code = 200;
        } catch (\Throwable $th) {
            $response = ['message' => 'failed destroying resources'];
            $code = 422;
            DB::rollBack();
        }

        return response()->json($response, $code);
    }

    public function requestedNotified($id)
    {
        DB::beginTransaction();
        try {
            WhatsappQueue::where([
                'transaction_mail_id' => $id,
                'request_notified' => false,
                'request_notified_at' => NULL
            ])->update([
                'request_notified' => true,
                'request_notified_at' => now('Asia/Jakarta')
            ]);
            DB::commit();
            $response = ['message' => 'request notified mail successfully, waiting queue '];
            $code = 200;
        } catch (\Throwable $th) {
            $response = ['message' => 'failed request notified mail'];
            $code = 422;
            DB::rollBack();
        }

        return response()->json($response, $code);
    }

    public function statusUpdate($id, Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric'
        ], [
            'user_id.numeric' => 'The processor must selected.'
        ]);
        DB::beginTransaction();
        try {
            $current_status = TransactionMail::find($id);
            $data = $request->except('_token');
            switch ($current_status->status) {
                case 'IN':
                    if ($data['status'] == 'PROCESS') {
                        $where_queue = [['transaction_mail_id', NULL]];
                        $data_queue = ['transaction_mail_id' => $current_status->id, 'current_status' => $data['status'], 'last_status' => $current_status->status, 'created_at' => now('Asia/Jakarta'), 'updated_at' => now('Asia/Jakarta'), 'user_id' => auth()->user()->id];
                    } else if ($data['status'] == 'FILED') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    } else if ($data['status'] == 'DISPOSITION') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    } else if ($data['status'] == 'REPLIED') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    }
                    WhatsappQueue::where($where_queue)->delete();
                    WhatsappQueue::insert($data_queue);
                    break;
                case 'PROCESS':
                    if ($data['status'] == 'FILED') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN']];
                        $data_queue =
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'FILED',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ];
                    } else if ($data['status'] == 'DISPOSITION') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN'], ['current_status', '!=', 'PROCESS']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    } else if ($data['status'] == 'REPLIED') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN'], ['current_status', '!=', 'PROCESS']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    }
                    WhatsappQueue::where($where_queue)->delete();
                    WhatsappQueue::insert($data_queue);
                    break;
                case 'FILED':
                    if ($data['status'] == 'DISPOSITION') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', NULL]];
                        $data_queue =
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'DISPOSITION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ];
                    } else if ($data['status'] == 'REPLIED') {
                        $where_queue = [['transaction_mail_id', $current_status->id], ['current_status', '!=', 'IN'], ['current_status', '!=', 'PROCESS'], ['current_status', '!=', 'FILED']];
                        $data_queue = [
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => 'ACCELERATION',
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => false,
                                'request_notified_at' => NULL,
                                'current_status' => $data['status'],
                                'last_status' => 'ACCELERATION',
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ],
                        ];
                    }
                    WhatsappQueue::where($where_queue)->delete();
                    WhatsappQueue::insert($data_queue);
                    break;
                case 'DISPOSITION':
                    $where_queue = [['transaction_mail_id', NULL]];
                    if ($data['status'] == 'REPLIED') {
                        $data_queue =
                            [
                                'transaction_mail_id' => $current_status->id,
                                'request_notified' => true,
                                'request_notified_at' => now('Asia/Jakarta'),
                                'current_status' => $data['status'],
                                'last_status' => $current_status->status,
                                'created_at' => now('Asia/Jakarta'),
                                'updated_at' => now('Asia/Jakarta'),
                                'user_id' => auth()->user()->id
                            ];
                    }
                    WhatsappQueue::where($where_queue)->delete();
                    WhatsappQueue::insert($data_queue);
                    break;
                case 'REPLIED':
                    $where_queue = [['transaction_mail_id', NULL]];
                    $data_queue = [
                        'transaction_mail_id' => $current_status->id,
                        'request_notified' => true,
                        'request_notified_at' => now('Asia/Jakarta'),
                        'current_status' =>  'ARCHIVE',
                        'last_status' => $current_status->status,
                        'created_at' => now('Asia/Jakarta'),
                        'updated_at' => now('Asia/Jakarta'),
                        'user_id' => auth()->user()->id
                    ];
                    WhatsappQueue::where($where_queue)->delete();
                    WhatsappQueue::insert($data_queue);
                    break;
                default:
                    break;
            }
            if ($request->has('reply_file_attachment')) {
                $file_attachment = json_decode($request->reply_file_attachment);
                $file_name = 'reply_file_attachment/' . $file_attachment->id . '.pdf';
                file_put_contents(public_path($file_name), base64_decode($file_attachment->data));
                $data['reply_file_attachment'] = $file_name;
            }
            if ($request->has('sincerely')) {
                $data['sincerely'] = json_encode($request->sincerely);
            }
            TransactionMail::find($id)->update($data);
            $response = ['message' => 'updating status mail successfully'];
            $code = 200;
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            $response = ['message' => 'failed updating status mail'];
            $code = 422;
        }
        return response()->json($response, $code);
    }

    public function showFile($folder, string $file_id) {}
}
