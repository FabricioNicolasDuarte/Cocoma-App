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

            // --- LÓGICA PARA EL AVATAR ---
            if ($request->hasFile('avatar')) {
                // Eliminar el avatar anterior si no es el de por defecto
                if ($user->avatar && $user->avatar !== 'images/avatars/default.png') {
                    Storage::disk('public')->delete(str_replace('storage/', '', $user->avatar));
                }

                // Guardar el nuevo avatar y obtener la ruta
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = 'storage/' . $path;
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

            // Eliminar el avatar del usuario si no es el de por defecto
            if ($user->avatar && $user->avatar !== 'images/avatars/default.png') {
                Storage::disk('public')->delete(str_replace('storage/', '', $user->avatar));
            }

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/');
        }
    }

