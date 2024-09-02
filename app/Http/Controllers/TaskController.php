<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index():mixed
    {
        if (!isset($_GET['project_id'])) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'project id needs to be given'
                ]
            );
        }
        $project_id=intval($_GET['project_id']);
        $ownedProjects=Project::where('user_id', Auth::user()->id)->pluck('id')->toArray();

        if (!Auth::user()->hasPermission('edit-any-task')
            && !(Auth::user()->hasPermission('edit-task') && in_array($project_id, $ownedProjects))
        ) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'you are not authorized to do this.'
                ]
            );
        }

        return response()->json(
            [
                'status' => true,
                'data' => Task::orderByDesc('id')
                    ->where('project_id', $project_id)->get()
            ]
        );
    }

    /**
     * Store
     *
     * @param \App\Http\Requests\StoreTaskRequest $request request
     *
     * @return mixed
     */
    public function store(StoreTaskRequest $request):mixed
    {
        $p=Task::create(
            [
                'name' => $request->name,
                'description' => $request->description,
                'project_id' => $request->project_id,
                'status' => $request->status
            ]
        );
        return response()->json(
            [
                'status' => true,
                'data' => $p
            ]
        );
    }

    /**
     * Details
     *
     * @param \App\Models\Task $task task
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(Task $task):mixed
    {
        $user=Auth::user();
        // permission check
        if ($user->hasPermission('edit-any-task')===true
            || ($user->hasPermission('edit-task')
            && $task->project->user_id==$user->id)
        ) {
            return response()->json(
                [
                    'status' => true,
                    'data' => $task
                ]
            );
        }
        return response()->json(
            [
            'message' => 'you are not authorized to do this.'
            ], 403
        );
    }



    /**
     * Update
     *
     * @param \App\Http\Requests\UpdateTaskRequest $request request
     * @param \App\Models\Task                     $task    task
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $p=$task->update(
            [
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
            ]
        );
        return response()->json(
            [
            'status' => true,
            ]
        );
    }

    /**
     * Remove
     *
     * @param \App\Models\Task $task task
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        $user=Auth::user();
        // permission check
        if ($user->hasPermission('delete-any-task')===true
            || ($user->hasPermission('delete-task')
            && $task->project->user_id==$user->id)
        ) {
            $task->delete();
            return response()->json(
                [
                    'status' => true,
                    'data' => $task
                ]
            );
        }
        return response()->json(
            [
                'status' => true
            ]
        );
    }
}
