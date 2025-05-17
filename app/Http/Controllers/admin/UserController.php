<?php

namespace App\Http\Controllers\admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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

        return view('pages.admin.user.edit', compact([
            'user',
            'gender',
            'role',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        $data = $request->validate([
            "gelar_depan" => "nullable|string",
            "name" => "required|string",
            "gelar_belakang" => "nullable|string",
            "no_hp" => [
                'required',
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'
            ],
            "gender_id" => "required|numeric|exists:gender,id",
            "role_id" => "required|numeric|exists:role,id",
        ]);

        $user->update($data);

        return redirect()->route('user.index')->withNotify('Data user ' . $user->name . ' berhasil diubah.');
    }

    public function destroy(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        if($user->d == Auth::user()->id) {
            return redirect()->route('user.index')->withNotifyerror('Data user yang anda hapus adalah akun anda sekarang');
        }

        if($user->role_id == 1) {
            return redirect()->route('user.index')->withNotifyerror('Anda tidak bisa menghapus user dengan role Superadmin');
        }

        $user->delete();

        return redirect()->route('user.index')->withNotify('Data user ' . $user->name . ' berhasil dihapus.');
    }
}
