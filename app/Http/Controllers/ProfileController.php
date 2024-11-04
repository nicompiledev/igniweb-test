<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

/**
 * ProfileController: Handles user profile management.
 */
class ProfileController extends Controller
{
    /**
     * Display the user's profile edit form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        // Render the profile edit view with authenticated user data
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Retrieve the authenticated user
        $user = $request->user();

        // Check if profile image removal is requested
        if ($request->has('remove_profile_image') && $request->input('remove_profile_image') == '1') {
            // Remove existing profile image if present
            if ($user->profile_image) {
                Storage::delete('public/' . $user->profile_image);
                $user->profile_image = null;
            }
        } else {
            // Handle new profile image upload
            if ($request->hasFile('profile_image')) {
                // Validate image upload
                $request->validate([
                    'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                // Remove existing image if uploading new one
                if ($user->profile_image) {
                    Storage::delete('public/' . $user->profile_image);
                }

                // Store new profile image
                $path = $request->file('profile_image')->store('profile_images', 'public');
                $user->profile_image = $path;
            }
        }

        // Update other profile fields
        $user->fill($request->validated());

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save user updates
        $user->save();

        // Redirect to profile edit page with success message
        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully');
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Retrieve the authenticated user
        $user = $request->user();

        // Verify password correctness for account deletion
        if (!Hash::check($request->password, $user->password)) {
            // Return error if password is incorrect
            return back()->withErrors([
                'password' => __('The password you entered is incorrect.'),
            ], 'userDeletion');
        }

        // Delete the user account
        $user->delete();

        // Log out the user
        Auth::logout();

        // Redirect to login page with account deletion success message
        return redirect('/login')->with('status', __('Your account has been deleted successfully.'));
    }
}
