<?php

namespace App\Http\Controllers;

use App\Task;
use App\Http\Requests\TaskStoreRequest;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json([
            'data' => $tasks
        ]);
    }

    public function taskList(Request $request)
    {
        $tasks = $request->user()->tasks()->orderBy('status')->get();
        return response()->json([
            'data' => $tasks
        ]);
    }

    /**
     * Get single resource
     *
     * @param Task $task
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show( Task $task )
    {

        return response()->json([
            'data' => $task
        ]);
    }

    /**
     * Update single resource
     *
     * @param TaskStoreRequest $request
     * @param Task $task
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update( TaskStoreRequest $request, Task $task )
    {
        $task->fill($request->all());
        $task->save();

        return response()->json([
            'status' => true,
            'data' => $task
        ]);
    }

    /**
     * Store new resource
     *
     * @param TaskStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store( TaskStoreRequest $request )
    {
        $task = new Task;
        $data = $request->all();
        $data['author_id'] = $request->user()->id;
        $task->fill($data);
        $task->save();
        return response()->json([
            'created' => true,
            'data' => [
                'id' => $task->id
            ]
        ]);
    }

    /**
     * Destroy single resource
     *
     * @param Task $task
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy( Task $task )
    {
        $task->delete();

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Destroy resources by ids
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroyMass( Request $request )
    {
        $request->validate([
            'ids' => 'required|array'
        ]);

        Task::destroy($request->ids);

        return response()->json([
            'status' => true
        ]);
    }

    public function toggleStatus(TaskStoreRequest $request, Task $task)
    {
        $task->status = $task->status == 2 ? 1 : 2;
        $task->save();
        return response()->json([
            'status' => true
        ]);
    }
}
