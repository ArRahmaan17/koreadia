<?php

namespace App\Http\Controllers\Dev\Mail;

use App\Http\Controllers\Controller;
use App\Models\MailType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.mail-type');
    }

    public function dataTable(Request $request)
    {
        $totalData = MailType::orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = MailType::select('*');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = MailType::select('*')
                ->where('name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('description', 'like', '%' . $request['search']['value'] . '%');

            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = MailType::select('*')
                ->where('name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('description', 'like', '%' . $request['search']['value'] . '%');

            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row['number'] = $request['start'] + ($index + 1);
            $row['name'] = $item->name;
            $row['description'] = $item->description;
            $row['priority'] = $item->priority ? 'Penting' : 'Biasa';
            $row['action'] = "<button class='btn btn-icon btn-warning edit' data-type='" . $item->id . "' ><i class='bx bx-pencil' ></i></button><button data-type='" . $item->id . "' class='btn btn-icon btn-danger delete'><i class='bx bxs-trash-alt' ></i></button>";
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

    public function all()
    {
        $response = ['message' => 'showing all resources successfully', 'data' => MailType::all()];
        $code = 200;
        if (MailType::count() == 0) {
            $response = ['message' => 'failed showing all resources', 'data' => MailType::all()];
            $code = 422;
        }

        return response()->json($response, $code);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:mail_types,name',
            'description' => 'required|min:5|max:200',
            'priority' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token');
            $data['priority'] = ($request->priority == 'on') ? true : false;
            MailType::create($data);
            $response = ['message' => 'creating resources successfully'];
            $code = 200;
            DB::commit();
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
        $data = MailType::find($id);
        $response = ['message' => 'showing resources successfully', 'data' => $data];
        $code = 200;
        if (empty($data)) {
            $response = ['message' => 'failed showing resources', 'data' => $data];
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
            'name' => 'required|unique:mail_types,name,' . $id,
            'description' => 'required|min:5|max:200',
        ]);
        DB::beginTransaction();
        try {
            MailType::find($id)->update($request->except('_token'));
            $response = ['message' => 'updating resources successfully'];
            $code = 200;
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = ['message' => 'failed updating resources'];
            $code = 422;
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
            MailType::find($id)->delete();
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
}
