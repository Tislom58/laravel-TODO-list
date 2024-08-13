<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;
use App\Models\TasksTags;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('archived', 0)->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    public function create()
    {
        $tags = Tag::all('name');

        return view('tasks.create', [
            'tags' => $tags,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $task = new Task();
        $task->description = $request->description;
        $task->due_date = $request->due_date;

        $task->save();

        foreach($request->tags as $tag)
        {
            $task_tag = new TasksTags();
            $task_tag->task_id = $task->id;
            $task_tag->tag_id = Tag::where('name', $tag)->firstOrFail()->id;

            $task_tag->save();
        }

        return redirect('/tasks');
    }

    public function complete(string $id): RedirectResponse
    {
        $task = Task::where('id', $id)->firstOrFail();
        $task->archived = 1;

        $task->save();

        return redirect('/tasks');
    }

    public function destroy(string $id): RedirectResponse
    {
        $task = Task::where('id', $id)->firstOrFail();
        $task->delete();

        return redirect('/tasks');
    }

    public function edit(string $id)
    {
        $task = Task::where('id', $id)->firstOrFail();

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $task = Task::find($id);

        $task->description = $request->description;
        $task->due_date = $request->due_date;

        $task->save();

        $current_tags = TasksTags::where('task_id', $id)->get();
        $request_tags = $request->tags;
        $new_tag_ids = [];
        $current_tag_ids = [];

        foreach($request_tags as $tag)
            $new_tag_ids[] = Tag::where('name', $tag)->firstOrFail()->id;

        foreach($current_tags as $current_tag)
        // Remove tag records associated with task
        {
            if(!(in_array($current_tag->id, $new_tag_ids)))
                $current_tag->delete();
            else
                $current_tag_ids[] = $current_tag->id;
        }

        foreach($new_tag_ids as $tag_id)
        // Add records of new tags except those already present
        {
            if(!(in_array($tag_id, $current_tag_ids)))
            {
                $task_tag = new TasksTags();
                $task_tag->task_id = $id;
                $task_tag->tag_id = $tag_id;
                $task_tag->save();
            }
        }

        return redirect('/tasks');
    }
}
