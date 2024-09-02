<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index():mixed
    {
        if (!Auth::user()->hasPermission('edit-any-project')
            && !Auth::user()->hasPermission('edit-project')
        ) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'you are not authorized to do this.'
                ]
            );
        }
        if (Auth::user()->hasPermission('edit-any-project')) {
            return response()->json(
                [
                    'status' => true,
                    'data' => Project::orderByDesc('id')->get()
                ]
            );
        }

        return response()->json(
            [
                'status' => true,
                'data' =>Project::orderByDesc('id')
                    ->where('user_id', Auth::user()->id)->get()
            ]
        );
    }

    /**
     * Store
     * @param \App\Http\Requests\StoreProjectRequest $request request
     *
     * @return mixed
     */
    public function store(StoreProjectRequest $request):mixed
    {
        $p=Project::create(
            [
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
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
     * @param \App\Models\Project $project project
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(Project $project):mixed
    {
        $user=Auth::user();
        // permission check
        if ($user->hasPermission('edit-any-project')===true
            || ($user->hasPermission('edit-project')
            && $project->user_id==$user->id)
        ) {
            $project->load('tasks');
            return response()->json(
                [
                    'status' => true,
                    'data' => $project
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
     * @param \App\Http\Requests\UpdateProjectRequest $request request
     * @param \App\Models\Project                     $project project
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $p=$project->update(
            [
            'name' => $request->name,
            'description' => $request->description
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
     * @param \App\Models\Project $project project
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project)
    {
        $user=Auth::user();
        // permission check
        if ($user->hasPermission('delete-any-project')===true
            || ($user->hasPermission('delete-project')
            && $project->user_id==$user->id)
        ) {
            $project->delete();
            return response()->json(
                [
                    'status' => true,
                    'data' => $project
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
