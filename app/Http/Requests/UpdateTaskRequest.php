<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Models\Project;
class UpdateTaskRequest extends ApiRequest
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
        if ($user->hasPermission('edit-any-task')===true) {
            return true;
        }
        if ($user->hasPermission('edit-task')===false) {
            return false;
        }

        $task=$this->route('task');
        if (!$task) {
            return false;
        }
        //gather project of given task
        $project=Project::find($task->project_id);
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
            'status' => 'required|string',
        ];
    }
}
