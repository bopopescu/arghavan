<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $permissions = Permission::paginate(Controller::C_PAGINATE_SIZE);

            return $permissions;
        }

        return view ('permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(PermissionRequest $request)
    {
        if ($request->ajax())
        {
            // Check for duplicate
            $newPermission = Permission::createIfNotExist($request);

            return [
                'status' => is_null($newPermission) ? 1 : 0,
                'permission' => $newPermission
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        if ($request->ajax())
        {
            $permission->update([ 
                                'key'  => $request->key,
                                'name'  => $request->name,
                                'description'  => $request->description,
                                ]);

            return [
                'status' => 0,
                'permission' => $permission
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Permission $permission)
    {
        if ($request->ajax())
        {
            $permission->delete();

            return [
                'status' => 0
            ];
        }
    }

    /**
     * Return permissions list
     */
    public function allPermissions ()
    {
        $list  = Permission::select('id', 'key', 'name', 'description')
                                ->get();

        return $list;
    }
}
