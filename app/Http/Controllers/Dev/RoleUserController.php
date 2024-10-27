<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.role-user');
    }
    public function allUser(Request $request)
    {
        $data = User::whereRaw('id not in (' . (($request->all) ? '0' : 'select user_id from role_users') . ')')->get();
        $response = ['message' => 'showing all resource successfully', 'data' => $data];
        $code = 200;
        if (empty($data)) {
            $code = 404;
            $response = ['message' => 'failed showing all resource', 'data' => $data];
        }
        return response()->json($response, $code);
    }
    public function dataTable(Request $request)
    {
        $totalData = RoleUser::orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = RoleUser::select('role_users.id', 'u.name as name', 'r.name as role')
                ->join('roles as r', 'r.id', '=', 'role_users.role_id')
                ->join('users as u', 'u.id', '=', 'role_users.user_id');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = RoleUser::select('role_users.id', 'u.name as name', 'r.name as role')
                ->join('roles as r', 'r.id', '=', 'role_users.role_id')
                ->join('users as u', 'u.id', '=', 'role_users.user_id')
                ->where('name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('r.name', 'like', '%' . $request['search']['value'] . '%');

            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = RoleUser::select('u.name as name', 'r.name as role')
                ->join('roles as r', 'r.id', '=', 'role_users.role_id')
                ->join('users as u', 'u.id', '=', 'role_users.user_id')
                ->where('name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('r.name', 'like', '%' . $request['search']['value'] . '%');

            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw($request['order'][0]['name'] . ' ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row['number'] = $request['start'] + ($index + 1);
            $row['name'] = $item->name;
            $row['role'] = $item->role;
            $row['action'] = "<button class='btn btn-icon btn-warning edit' data-roleuser='" . $item->id . "' ><i class='bx bx-pencil' ></i></button><button data-roleuser='" . $item->id . "' class='btn btn-icon btn-danger delete'><i class='bx bxs-trash-alt' ></i></button>";
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
        $response = ['message' => 'showing all resources successfully', 'data' => RoleUser::all()];
        $code = 200;
        if (RoleUser::count() == 0) {
            $response = ['message' => 'failed showing all resources', 'data' => RoleUser::all()];
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
            'user_id' => 'required|numeric',
            'role_id' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            RoleUser::create($request->except('_token'));
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
        $data = RoleUser::find($id);
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
            'user_id' => 'required|numeric',
            'role_id' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            RoleUser::find($id)->update($request->except('_token'));
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
            RoleUser::find($id)->delete();
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
