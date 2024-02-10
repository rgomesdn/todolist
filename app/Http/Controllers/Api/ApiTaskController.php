<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTaskController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $task = Task::all();

            return response()->json([
                'tasks' => $task->toJson(JSON_PRETTY_PRINT)
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *  Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try
        {
            $validated = $request->validate([
                'title'         => 'required|unique:tasks|min:3',
                'description'   => 'required|min:3',
                'status'        => 'required'
            ],[
                'title.required'        => __('This_field_is_required'),
                'description.required'  => __('This_field_is_required'),
                'status.required'       => __('This_field_is_required'),
            ]);

            Task::create([
                'title'         => $request->title,
                'description'   => $request->description,
                'status'        => $request->status,
                'user_id'       => Auth::user()->id
            ]);

            return response()->json([
                'message' => 'Task created successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }
    }

    /**
     *  Display the specified resource.
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $task = Task::findOrFail($request->id);
            $data = json_decode($task->toJson(JSON_PRETTY_PRINT));

            return response()->json([
                'title'         => $data->title,
                'description'   => $data->description,
                'status'        => $data->status,
                'user_id'       => $data->user_id
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }
    }

    /**
     *  Update the specified resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validated = $request->validate([
                'title'         => 'required|min:3',
                'description'   => 'required|min:3',
                'status'        => 'required'
            ],[
                'title.required'        => __('This_field_is_required'),
                'description.required'  => __('This_field_is_required'),
                'status.required'       => __('This_field_is_required'),
            ]);

            $task = Task::findOrFail($request->id);

            $task->update([
                'title'         => $request->title,
                'description'   => $request->description,
                'status'        => $request->status
            ]);

            return response()->json([
                'message' => 'Task updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $task = Task::findOrFail($request->id);
            $task->delete();

            return response()->json([
                'message' => 'Task deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }
    }
}
