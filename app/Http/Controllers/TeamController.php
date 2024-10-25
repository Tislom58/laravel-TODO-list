<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function index()
    {
        // Pull team tasks from DB
        $team = User::find(Auth::id())->team;
        $team_tasks = $team->tasks->where('archived', 0);

        return view('team.index',[
            'team_tasks' => $team_tasks,
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
        $user = User::find(Auth::id());

        $team->name = $request->team_name;
        $team->creator_id = $user->id;
        $team->save();

        $user->team_id = $team->id;
        $user->save();

        return redirect(route('team.index'));
    }
}