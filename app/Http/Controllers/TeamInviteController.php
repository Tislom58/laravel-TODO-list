<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Team;

class TeamInviteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'exists:'.User::class.',email'],
        ]);

        $invite = $request;
        $invitee = User::where('email', $invite->user_email)->first();
        $inviter = Auth::id();

        $invitee->invited_to_team_by_user = $inviter;
        $invitee->save();

        return redirect()->route('team.index');
    }

    public function accept()
    {
        $current_user = User::find(Auth::id());
        $inviter = User::find($current_user->invited_to_team_by_user);

        $current_user->team_id = $inviter->team_id;
        $current_user->invited_to_team_by_user = null;
        $current_user->save();

        return redirect('/team');
    }

    public function decline()
    {
        $current_user = User::find(Auth::id());

        $current_user->invited_to_team_by_user = null;
        $current_user->save();

        return redirect('/team/join');
    }
}
