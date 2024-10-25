<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TeamTask;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamTaskController extends Controller
{
    public function create()
    {
        $user = User::find(Auth::id());
        $team = $user->team;

        return view('team.tasks.create', [
            'user' => $user,
            'team' => $team,
        ]);
    }

    public function store(Request $request)
    {
        $team_task = new TeamTask();
        $team_task->description = $request->description;
        $team_task->due_date = $request->due_date;
        $team_task->archived = 0;
        $team_task->author_id = Auth::id();
        $team_task->team_id = User::find(Auth::id())->team_id;

        $team_task->save();

        if($request->assigned_to)
        {
            $team_task->users()->attach($request->assigned_to);
        }

        return redirect(route('team.index'));
    }

    public function destroy(string $id)
    {
        TeamTask::find($id)->delete();

        return redirect(route('team.index'));
    }

    public function complete(string $id)
    {
        $team_task = TeamTask::find($id);
        $team_task->archived = 1;
        $team_task->save();

        return redirect(route('team.index'));
    }

    public function edit(string $id)
    {
        $team_task = TeamTask::find($id);

        if (User::find(Auth::id())->team_id === $team_task->team_id)
        {
            return view('team.tasks.edit', [
                'task' => $team_task,
                'team' => $team_task->team,
            ]);
        }
        return redirect(route('team.index'));
    }

    public function update(string $id, Request $request)
    {
        $team_task = TeamTask::find($id);

        $team_task->description = $request->description;
        $team_task->due_date = $request->due_date;

        $team_task->save();

        if($request->assigned_to)
        {
            $team_task->users()->sync($request->assigned_to);
        }

        return redirect(route('team.index'));
    }

    public function toggle_email_reminder(string $id)
    {
        // Query
        $result = DB::table('team_task_user')
            ->where('user_id', '=', Auth::id())
            ->where('team_task_id', '=', $id)
            ->first();

        // Toggle the value
        $toggle_value = !($result->email_reminder);

        // Save changes
        DB::table('team_task_user')
            ->where('user_id', '=', Auth::id())
            ->where('team_task_id', '=', $id)
            ->update(['email_reminder' => $toggle_value]);

        return redirect(route('team.index'));
    }

    public function toggle_push_reminder(string $id)
    {
        // Query
        $result = DB::table('team_task_user')
            ->where('user_id', '=', Auth::id())
            ->where('team_task_id', '=', $id)
            ->first();

        // Toggle the value
        $toggle_value = !($result->push_reminder);

        // Save changes
        DB::table('team_task_user')
            ->where('user_id', '=', Auth::id())
            ->where('team_task_id', '=', $id)
            ->update(['push_reminder' => $toggle_value]);

        return redirect(route('team.index'));

    }
}
