<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = Route::getRoutes()->getRoutesByMethod()['GET'];
        $menus = Menu::where('parent', 0)->orWhere('route', 'like', '#%')->get();
        $roles = Role::all();

        return view('master.menu', compact('menus', 'routes', 'roles'));
    }

    public function dataTable(Request $request)
    {
        $totalData = Menu::orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = Menu::select('*');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'].' '.$request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = Menu::select('*')
                ->where('name', 'like', '%'.$request['search']['value'].'%')
                ->orWhere('route', 'like', '%'.$request['search']['value'].'%');

            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw($request['columns'][$request['order'][0]['column']]['name'].' '.$request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = Menu::select('*')
                ->where('name', 'like', '%'.$request['search']['value'].'%')
                ->orWhere('route', 'like', '%'.$request['search']['value'].'%');

            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw($request['columns'][$request['order'][0]['column']]['name'].' '.$request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row['number'] = $request['start'] + ($index + 1);
            $row['name'] = $item->name;
            $row['description'] = $item->description;
            $row['action'] = (($item->parent == 0) ? "<button class='btn btn-icon btn-info parent' data-menu='".$item->id."' ><i class='bx bx-plus' ></i></button>" : '')."<button class='btn btn-icon btn-warning edit' data-menu='".$item->id."' ><i class='bx bx-pencil' ></i></button><button data-menu='".$item->id."' class='btn btn-icon btn-danger delete'><i class='bx bxs-trash-alt' ></i></button>";
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
        DB::beginTransaction();
        $request->validate([
            'name' => 'required|min:2|max:20|unique:menus,name',
            'route' => 'required',
            'icon' => 'required',
            'parent' => 'required',
            'roles' => 'required|array',
        ]);
        try {
            $data = $request->except('_token', 'id', 'role');
            $menu = Menu::create($data);
            $roleMenu = array_map(function ($data) use ($menu) {
                return ['role_id' => $data, 'menu_id' => $menu->id, 'created_at' => now('Asia/Jakarta')];
            }, $request->roles);
            RoleMenu::insert($roleMenu);
            DB::commit();
            $response = ['message' => 'Creating resource successfully'];
            $code = 200;
        } catch (\Throwable $th) {
            DB::rollBack();
            $code = 422;
            $response = ['message' => 'Failed creating resource'];
        }

        return response()->json($response, $code);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Menu::with('roles')->find($id);
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
        DB::beginTransaction();
        $request->validate([
            'name' => 'required|min:2|max:20|unique:menus,name,'.$id,
            'route' => 'required',
            'icon' => 'required',
            'parent' => 'required',
            'roles' => 'required|array',
        ]);
        try {
            $data = $request->except('_token', 'id', 'role');
            $menu = Menu::find($id)->update($data);
            RoleMenu::where('menu_id', $id)->delete();
            $roleMenu = array_map(function ($data) use ($id) {
                return ['role_id' => $data, 'menu_id' => $id, 'created_at' => now('Asia/Jakarta')];
            }, $request->roles);
            RoleMenu::insert($roleMenu);
            DB::commit();
            $response = ['message' => 'Updating resource successfully'];
            $code = 200;
        } catch (\Throwable $th) {
            DB::rollBack();
            $code = 422;
            $response = ['message' => 'Failed updating resource'];
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
            if (empty(collect(Menu::with('child')->find($id)->child)->toArray())) {
                Menu::destroy($id);
                RoleMenu::where('menu_id', $id)->delete();
                DB::commit();
                $response = ['message' => 'Deleting resource successfully'];
                $code = 200;
            } else {
                $response = ['message' => "Failed deleting resource. This data is still being used in other data. You can't delete it until it's removed from those data"];
                $code = 422;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = ['message' => 'failed deleting resource'];
            $code = 422;
        }

        return response()->json($response, $code);
    }
}
