<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
/**
 * Display the user's profile form.
 */
public function edit(Request $request): View
{
    return view('profile.edit', [
        'user' => $request->user(),
    ]);
}

/**
 * Update the user's profile information.
 */
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    $user->fill($request->validated());

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // --- LÓGICA PARA EL AVATAR ADAPTADA A S3 ---
    if ($request->hasFile('avatar')) {
        // Eliminar el avatar anterior de S3 si no es el de por defecto
        if ($user->avatar && $user->avatar !== 'images/avatars/default.png') {
            Storage::disk('s3')->delete($user->avatar);
        }

        // Guardar el nuevo avatar en S3 y obtener la ruta
        // Guardará el archivo en la carpeta 'avatars' de tu bucket S3
        $path = $request->file('avatar')->store('avatars', 's3');

        // Guardamos solo la ruta devuelta por S3, sin el prefijo 'storage/'
        $user->avatar = $path;
    }
    // --- FIN DE LA LÓGICA PARA EL AVATAR ---

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}

/**
 * Delete the user's account.
 */
public function destroy(Request $request): RedirectResponse
{
    $request->validateWithBag('userDeletion', [
        'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    // Eliminar el avatar del usuario de S3 si no es el de por defecto
    if ($user->avatar && $user->avatar !== 'images/avatars/default.png') {
        Storage::disk('s3')->delete($user->avatar);
    }

    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
}
}

