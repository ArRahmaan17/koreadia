<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.employee');
    }

    public function dataTable(Request $request)
    {
        $totalData = Employee::orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = Employee::select('*');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = Employee::select('*')
                ->where('name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('phone_number', 'like', '%' . $request['search']['value'] . '%');

            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = Employee::select('*')
                ->where('name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('phone_number', 'like', '%' . $request['search']['value'] . '%');

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
            $row['phone_number'] = $item->phone_number;
            $row['action'] = "<button class='btn btn-icon btn-warning edit' data-employee='" . $item->id . "' ><i class='bx bx-pencil' ></i></button><button data-employee='" . $item->id . "' class='btn btn-icon btn-danger delete'><i class='bx bxs-trash-alt' ></i></button>";
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
            'name' => 'required|unique:employees,name|min:5|max:30',
            'phone_number' => 'required|unique:employees,phone_number|min:18|max:19',
        ]);
        DB::beginTransaction();
        try {
            $codeResponse = 301;
            if (env('WHATSAPP_API')) {
                $registered = Http::get(env('WHATSAPP_URL') . 'phone-check/' . unFormattedPhoneNumber($request->phone_number));
                $codeResponse = $registered->status();
            }
            $data = $request->except('_token');
            if ($codeResponse < 300) {
                $data['valid'] = true;
            }
            Employee::create($data);
            $response = ['message' => 'creating resources successfully'];
            $code = 200;
            DB::commit();
        } catch (\Throwable $th) {
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
        $data = Employee::find($id);
        $response = ['message' => 'showing resources successfully', 'data' => $data];
        $code = 200;
        if (empty($data)) {
            $response = ['message' => 'failed showing resources', 'data' => $data];
            $code = 404;
        }

        return response()->json($response, $code);
    }

    public function all()
    {
        $data = Employee::all();
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
            'name' => 'required|unique:employees,name,' . $id . '|min:5|max:30',
            'phone_number' => 'required|unique:employees,phone_number,' . $id . '|min:18|max:19',
        ]);
        DB::beginTransaction();
        try {
            $codeResponse = 301;
            if (env('WHATSAPP_API')) {
                $registered = Http::get(env('WHATSAPP_URL') . 'phone-check/' . unFormattedPhoneNumber($request->phone_number));
                $codeResponse = $registered->status();
            }
            $data = $request->except('_token');
            if ($codeResponse < 300) {
                $data['valid'] = true;
            } else {
                $data['valid'] = false;
            }
            Employee::find($id)->update($data);
            DB::commit();
            $response = ['message' => 'updating resources successfully'];
            $code = 200;
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
            Employee::find($id)->delete();
            $response = ['message' => 'deleting resources successfully'];
            $code = 200;
        } catch (\Throwable $th) {
            $response = ['message' => 'failed deleting resources'];
            $code = 422;
        }

        return response()->json($response, $code);
    }
}
