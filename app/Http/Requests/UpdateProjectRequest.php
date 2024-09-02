<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class UpdateProjectRequest extends ApiRequest
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
        if ($user->hasPermission('edit-any-project')===true) {
            return true;
        }
        if ($user->hasPermission('edit-project')===false) {
            return false;
        }
        $project=$this->route('project');
        if (!$project) {
            return false;
        }
        // user owns this
        if ($project->user_id==$user->id) {
            return true;
        }
        return false;
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
