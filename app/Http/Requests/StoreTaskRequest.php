<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use Illuminate\Support\Facades\Log;

class StoreTaskRequest extends ApiRequest
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
        if ($user->hasPermission('create-any-task')===true) {
            return true;
        }
        if ($user->hasPermission('create-task')===false) {
            return false;
        }
        //gather project of given task
        $project=Project::find($this->get('project_id'));
        if (!$project) {
            return false;
        }
        // user owns project
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
            'project_id' => 'required|integer',
            'status' => 'required|string',
        ];
    }
}
