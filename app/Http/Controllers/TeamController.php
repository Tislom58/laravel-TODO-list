<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        // Pull team tasks and tags from DB
        $team = Auth::user()->team;
        $team_tasks = $team->tasks->where('archived', 0);
        $team_tags = $team->team_tags;

        return view('team.index',[
            'team_tasks' => $team_tasks,
            'users' => User::all(),
            'current_user' => Auth::user(),
            'team' => $team,
            'selected_user' => Null,
            'team_tags' => $team_tags,
        ]);
    }

    public function join()
    {
        // Redirect page
        return view('team.join');
    }

    public function create()
    {
        // Redirect page
        return view('team.create');
    }

    public function store(Request $request)
    {
        // Create new team
        $request->validate([
           'team_name' => ['required', 'string', 'max:255'],
        ]);

        $team = new Team();
        $user = Auth::user();

        $team->name = $request->team_name;
        $team->author_id = $user->id;
        $team->save();

        $user->team_id = $team->id;
        $user->save();

        return redirect(route('team.index'));
    }

    public function leave()
    {
        $user = Auth::user();
        $user->team_id = null;

        $user->save();

        return redirect(route('tasks.index'));
    }

    public function kick(string $id)
    {
        $kicked_member = User::find($id);
        $kicked_member->team_id = null;
        $kicked_member->save();

        return redirect(route('team.index'));
    }

    public function disband()
    {
        $team = Auth::user()->team;
        $team->delete();

        return redirect(route('tasks.index'));
    }
}
