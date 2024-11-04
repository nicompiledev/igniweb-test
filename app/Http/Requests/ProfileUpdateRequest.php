<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


/**
 * ProfileUpdateRequest: Validates user profile update requests.
 */
class ProfileUpdateRequest extends FormRequest
{
    /**
     * Defines validation rules for profile update requests.
     *
     * @return array Validation rules
     */
    public function rules(): array
    {
        return [
            'username' => [
                // Username validation
                'required', // Mandatory field
                'string', // String type
                'max:255', // Maximum 255 characters
                Rule::unique(User::class)->ignore($this->user()->id), // Unique username, excluding current user ID
            ],
            'email' => [
                // Email validation
                'required', // Mandatory field
                'string', // String type
                'lowercase', // Convert to lowercase
                'email', // Valid email format
                'max:255', // Maximum 255 characters
                Rule::unique(User::class)->ignore($this->user()->id), // Unique email, excluding current user ID
            ],
            'profile_image' => [
                // Profile image validation
                'nullable', // Optional field
                'image', // Image type
                'mimes:jpeg,png,jpg,gif,svg', // Accepted image formats
                'max:2048', // Maximum 2048 kilobytes (2MB)
            ],
        ];
    }
}
