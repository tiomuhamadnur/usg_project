<?php

namespace App\Http\Controllers\admin;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        // hanya index
        $this->middleware('permission:master.read')->only('index');

        // selain index
        $this->middleware('permission:master.write')
            ->except('index');
    }

public function index(RoleDataTable $dataTable)
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        return $dataTable->render('pages.admin.role.index', compact([
            'permissions',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'permission_names' => 'array',
        ]);

        $role = Role::updateOrCreate(['name' => $request->name], ['name' => $request->name]);

        if (!empty($request->permission_names)) {
            $role->syncPermissions($request->permission_names);
        }

        return redirect()->route('role.index')->withNotify('Data berhasil ditambahkan');
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
        // Ambil role
        $role = Role::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permission_names' => 'array',
        ]);

        // Update nama role
        $role->update([
            'name' => $validated['name'],
        ]);

        // Update permission
        if (!empty($validated['permission_names'])) {
            $role->syncPermissions($validated['permission_names']);
        } else {
            $role->syncPermissions([]); // kosongkan permission
        }
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        // detach semua permission
        $role->permissions()->detach();

        // detach semua user
        $role->users()->detach(); // jika pakai HasRoles trait, relasi ini ada

        // hapus role
        $role->delete();

        return redirect()->route('role.index')->withNotify('Data berhasil dihapus');
    }
}
