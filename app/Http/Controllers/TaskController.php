<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $task = Task::all();

            return view('task.list', [
                'tasks' => $task->toJson(JSON_PRETTY_PRINT)
            ]);
        } catch (\Exception $e) {
            request()->session()->flash('message', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $validated = $request->validate([
                'title'         => 'required|unique:tasks|min:3',
                'description'   => 'required|min:3',
                'status'        => 'required'
            ], [
                'title.required'        => __('This_field_is_required'),
                'description.required'  => __('This_field_is_required'),
                'status.required'       => __('This_field_is_required'),
            ]);

            Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'user_id' => Auth::user()->id
            ]);

            return redirect('/tasks');
        } catch (\Exception $e) {
            request()->session()->flash('message', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    public function edit($id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try{
            $task = Task::findOrFail($id);
            return view('task.edit', ['task' => $task]);
        } catch (\Exception $e) {
            request()->session()->flash('message', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function update(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $validated = $request->validate([
                'title'         => 'required|min:3',
                'description'   => 'required|min:3',
                'status'        => 'required'
            ], [
                'title.required'        => __('This_field_is_required'),
                'description.required'  => __('This_field_is_required'),
                'status.required'       => __('This_field_is_required'),
            ]);

            $task = Task::findOrFail($request->id);

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status
            ]);

            return redirect('/tasks');
        } catch (\Exception $e) {
            request()->session()->flash('message', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function destroy($id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return redirect('/tasks');
        } catch (\Exception $e) {
            request()->session()->flash('message', $e->getMessage());
            return redirect()->back();
        }
    }
}
