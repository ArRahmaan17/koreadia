<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationUser;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.user');
    }

    public function dataTable(Request $request)
    {
        $totalData = User::join('role_users', 'role_users.user_id', '=', 'users.id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')->orderBy('id', 'asc')
            ->leftJoin('organization_users', 'organization_users.user_id', '=', 'users.id')
            ->leftJoin('organizations', 'organization_users.organization_id', '=', 'organizations.id')
            ->select('users.*', 'roles.name as role', 'organizations.name as organization')->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = User::join('role_users', 'role_users.user_id', '=', 'users.id')
                ->join('roles', 'role_users.role_id', '=', 'roles.id')
                ->leftJoin('organization_users', 'organization_users.user_id', '=', 'users.id')
                ->leftJoin('organizations', 'organization_users.organization_id', '=', 'organizations.id')
                ->select('users.*', 'roles.name as role', 'organizations.name as organization');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = User::join('role_users', 'role_users.user_id', '=', 'users.id')
                ->join('roles', 'role_users.role_id', '=', 'roles.id')
                ->leftJoin('organization_users', 'organization_users.user_id', '=', 'users.id')
                ->leftJoin('organizations', 'organization_users.organization_id', '=', 'organizations.id')
                ->select('users.*', 'roles.name as role', 'organizations.name as organization')
                ->where('name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('username', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('phone_number', 'like', '%' . $request['search']['value'] . '%');

            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'] . ' ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = User::join('role_users', 'role_users.user_id', '=', 'users.id')
                ->join('roles', 'role_users.role_id', '=', 'roles.id')
                ->leftJoin('organization_users', 'organization_users.user_id', '=', 'users.id')
                ->leftJoin('organizations', 'organization_users.organization_id', '=', 'organizations.id')
                ->select('users.*', 'roles.name as role', 'organizations.name as organization')
                ->where('name', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('username', 'like', '%' . $request['search']['value'] . '%')
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
            $row['username'] = $item->username;
            $row['phone_number'] = $item->phone_number;
            $row['role'] = $item->role;
            $row['organization'] = $item->organization ?? trans('Kosong');
            $row['valid'] = $item->valid ? 'Valid' : 'Belum Valid';
            $row['action'] = "<button class='btn btn-icon btn-warning edit' data-user='" . $item->id . "' ><i class='bx bx-pencil' ></i></button><button data-user='" . $item->id . "' class='btn btn-icon btn-danger delete'><i class='bx bxs-trash-alt' ></i></button>";
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
        $response = ['message' => 'showing all resources successfully', 'data' => User::where('id', '!=', auth()->user()->id)->get()];
        $code = 200;
        if (User::count() == 0) {
            $response = ['message' => 'failed showing all resources', 'data' => User::where('id', '!=', auth()->user()->id)->get()];
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
            'name' => 'required|unique:users,name',
            'username' => 'required|min:5|max:15|unique:users,username',
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required|same:password',
            'phone_number' => 'required|min:18|max:19|unique:users,phone_number',
            'avatar' => 'required',
            'role' => 'required|exists:roles,id',
            'organization' => 'exists:organizations,id',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token', 'confirm_password');
            if ($request->has('avatar')) {
                $avatar = json_decode($request->avatar);
                $file_name = 'images/' . $avatar->id . '.jpg';
                file_put_contents(public_path($file_name), base64_decode($avatar->data));
                $data['avatar'] = $file_name;
            }
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            RoleUser::insert(['user_id' => $user->id, 'role_id' => $request->role, 'created_at' => now('Asia/Jakarta'), 'updated_at' => now('Asia/Jakarta')]);
            if ($request->has('organization')) {
                OrganizationUser::insert(['user_id' => $user->id, 'organization_id' => $request->organization, 'created_at' => now('Asia/Jakarta'), 'updated_at' => now('Asia/Jakarta')]);
            }
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
        $data = User::with('role.roles')->find($id);
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
            'name' => 'required|unique:users,name,' . $id,
            'username' => 'required|min:5|max:15|unique:users,username,' . $id,
            'password' => 'string|same:confirm_password',
            'confirm_password' => 'string|same:password',
            'phone_number' => 'required|min:18|max:19|unique:users,phone_number,' . $id,
            'role' => 'required|exists:roles,id',
            'organization' => 'numeric|exists:organizations,id',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token', 'confirm_password');
            if ($request->has('avatar')) {
                $avatar = json_decode($request->avatar);
                $file_name = 'images/' . $avatar->id . '.jpg';
                file_put_contents(public_path($file_name), base64_decode($avatar->data));
                $data['avatar'] = $file_name;
            }
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            User::find($id)->update($data);
            RoleUser::where('user_id', $id)->update(['role_id' => $request->role]);
            if ($request->has('organization')) {
                OrganizationUser::where('user_id', $id)->update(['organization_id' => $request->organization]);
            }
            $response = ['message' => 'updating resources successfully'];
            $code = 200;
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
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
            User::find($id)->delete();
            RoleUser::where('user_id', $id)->delete();
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
