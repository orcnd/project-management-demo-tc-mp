<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class StoreProjectRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $user=Auth::user();
        // ony auth users can have this
        if (!$user) {
            return false;
        }
        return $user->hasPermission('create-project');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
        ];
    }
}
