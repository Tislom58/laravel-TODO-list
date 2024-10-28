<?php

namespace App\Http\Controllers;

use App\Models\TeamTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamTagController extends Controller
{
    public function create(Request $request)
    {
        return view('team.tags.create');
    }
    public function store(Request $request)
    {
        $request->validate([
           'name' => ['required', 'string', 'max:255'],
           'color' => ['hex_color'],
        ]);

        $new_tag = new TeamTag();
        $new_tag->name = $request->name;
        $new_tag->color = $request->color;
        $new_tag->team_id = Auth::user()->team_id;
        $new_tag->author_id = Auth::id();
        $new_tag->save();

        return redirect()->route('team.index');
    }

    public function edit(string $id)
    {
        $tag = TeamTag::find($id);

        return view('team.tags.edit', ['tag' => $tag]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['hex_color'],
        ]);

        $tag = TeamTag::find($id);

        $tag->name = $request->name;
        $tag->color = $request->color;
        $tag->save();

        return redirect()->route('team.index');
    }

    public function destroy(string $id)
    {
        $tag = TeamTag::find($id);
        $tag->delete();

        return redirect()->route('team.index');
    }
}
