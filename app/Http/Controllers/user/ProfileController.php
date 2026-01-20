<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('pages.user.profile.index', compact([
            'user',
        ]));
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

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $uuid, ImageUploadService $imageService)
    {
        $request->validate([
            'old_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'required_with:old_password', 'confirmed', 'min:8'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai!',
            'new_password.min' => 'Password minimal 8 karakter',
        ]);

        $user = Auth::user();

        // ==========================
        // UPDATE FOTO (jika ada)
        // ==========================
        if ($request->hasFile('photo')) {

            // HAPUS FOTO LAMA (JIKA ADA)
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // UPLOAD FOTO BARU
            $imagePath = $imageService->uploadImage(
                $request->file('photo'),
                'user/profile/',
                null,
                250,
                60
            );

            // UPDATE DB
            $user->update([
                'photo' => $imagePath
            ]);
        }

        // ==========================
        // UPDATE PASSWORD (jika ada)
        // ==========================
        if ($request->filled('old_password') && $request->filled('new_password')) {

            // cek password lama
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withError('Password lama tidak sesuai.');
            }

            // cek password baru tidak boleh sama dengan password lama
            if (Hash::check($request->new_password, $user->password)) {
                return back()->withError('Password baru tidak boleh sama dengan password lama.');
            }

            // update password
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Password berhasil diubah. Silakan login kembali.']);
        }

        // ==========================
        // RETURN saat hanya update foto atau tidak ada perubahan
        // ==========================
        return back()->withNotify('Profil berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        //
    }
}
