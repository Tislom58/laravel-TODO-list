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
        $team = new Team();
        $user = Auth::user();

        $team->name = $request->team_name;
        $team->creator_id = $user->id;
        $team->save();

        $user->team_id = $team->id;
        $user->save();

        return redirect(route('team.index'));
    }
}
