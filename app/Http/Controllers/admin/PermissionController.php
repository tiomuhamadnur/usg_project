<?php

namespace App\Http\Controllers\admin;

use App\DataTables\PermissionDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        // hanya index
        $this->middleware('permission:master.read')->only('index');

        // selain index
        $this->middleware('permission:master.write')
            ->except('index');
    }

    public function index(PermissionDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.permission.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rawData = $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $data = Permission::updateOrCreate($rawData, $rawData);

        return redirect()
            ->route('permission.index')
            ->withNotify("Permission <strong>{$data->name}</strong> berhasil ditambahkan.");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);

        $rawData = $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id . ',id',
        ]);

        $permission->update($rawData);

        return redirect()
            ->route('permission.index')
            ->withNotify("Permission <b>{$permission->name}</b> berhasil diperbarui.");
    }

    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();

        return redirect()
            ->route('permission.index')
            ->withNotify("Permission <b>{$permission->name}</b> berhasil dihapus.");
    }
}
