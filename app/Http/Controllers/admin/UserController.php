<?php

namespace App\Http\Controllers\admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Role as ModelsRole;
// use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        // hanya index
        $this->middleware('permission:master.read')->only('index');

        // selain index
        $this->middleware('permission:master.write')
            ->except('index');
    }

    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.user.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
        $gender = Gender::all();
        $role = Role::all();
        $jabatan = ModelsRole::all();

        return view('pages.admin.user.edit', compact([
            'user',
            'gender',
            'role',
            'jabatan',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        $data = $request->validate([
            "gelar_depan" => "nullable|string",
            "name" => "required|string",
            "gelar_belakang" => "nullable|string",
            "inisial" => "required|string",
            "no_hp" => [
                'required',
                'regex:/^(?:62)8[1-9][0-9]{6,9}$/'
            ],
            "gender_id" => "required|numeric|exists:gender,id",
            "role_id" => "required|numeric|exists:role,id",
        ]);

        $validated = $request->validate([
            'role_name' => 'required|string|exists:roles,name',
        ]);

        $user->update($data);

        $user->syncRoles([$validated['role_name']]);

        return redirect()->route('user.index')->withNotify("Data user <b>{$user->name}</b> berhasil diubah.");
    }

    public function destroy(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        if($user->id == Auth::user()->id) {
            return redirect()->route('user.index')->withNotifyerror('Data user yang anda ban adalah akun anda sekarang');
        }

        if($user->role_id == 1) {
            return redirect()->route('user.index')->withNotifyerror('Anda tidak bisa melakukan ban pada user dengan role Superadmin');
        }

        if ($user->isBanned()) {
            $user->unban();
        } else {
            $user->ban();
        }

        return redirect()->route('user.index')->withNotify('Data user ' . $user->name . ' berhasil diubah statusnya.');
    }
}
