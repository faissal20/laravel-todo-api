<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // api resource api 

    public function index(Request $request)
    {
        $request->validate([
            'date' => 'date:Y/M/D'
        ]);

        $tasks = Task::orderBy('created_at', 'desc');

        // create date from Y/M/D format    
        if($request->date){
            $date = date_create_from_format('Y/m/d', $request->date);
            $tasks = $tasks->whereDate('date', $date);
            
        }
        return TaskResource::collection($tasks->paginate(10));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $task = Task::create([ ...$request->all(), 'completed' => false ]);

        return new TaskResource($task);
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function update(Request $request, Task $task){
        $request->validate([
            'title' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'completed' => 'nullable|boolean',
            'date' => 'nullable|date:Y-m-d'
        ]);
        
        if($request->date){
            $task->date = $request->date;
        }
        if($request->title){
            $task->title = $request->title;
        }
        if($request->description){
            $task->description = $request->description;
        }
        if(!is_null($request->completed)){
            $task->completed = $request->completed ;
        }
        $task->save();

        return new TaskResource($task);
    }   

    public function destroy(Task $task){
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully!']);
    }
}
