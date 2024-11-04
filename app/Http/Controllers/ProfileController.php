<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Importar la clase Hash
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

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

        // Verificar si se solicitó la eliminación de la imagen de perfil
        if ($request->has('remove_profile_image') && $request->input('remove_profile_image') == '1') {
            if ($user->profile_image) {
                // Eliminar la imagen anterior si existe
                Storage::delete('public/' . $user->profile_image);
                $user->profile_image = null; // Establecer el campo de la imagen en null
            }
        } else {
            // Manejar la carga de una nueva imagen de perfil
            if ($request->hasFile('profile_image')) {
                $request->validate([
                    'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                if ($user->profile_image) {
                    // Eliminar la imagen anterior
                    Storage::delete('public/' . $user->profile_image);
                }

                // Guardar la nueva imagen
                $path = $request->file('profile_image')->store('profile_images', 'public');
                $user->profile_image = $path;
            }
        }

        // Actualizar otros campos de perfil
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        // Comprobar que la contraseña es correcta
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => __('The password you entered is incorrect.'),
            ], 'userDeletion');
        }

        // Eliminar al usuario
        $user->delete();

        // Cerrar sesión
        Auth::logout();

        // Redirigir al login después de eliminar la cuenta
        return redirect('/login')->with('status', __('Your account has been deleted successfully.'));
    }
}
