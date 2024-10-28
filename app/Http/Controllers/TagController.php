<?php

namespace App\Http\Controllers;

use App\Models\TasksTags;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $tags = $user->tags;

        return view('tags.index', [
            'tags' => $tags,
        ]);
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['hex_color'],
        ]);

        $tag = new Tag();
        $user = User::find(Auth::id());
        $tag->name = $request->name;
        $tag->color = $request->color;
        $tag->user_id = $user->id;

        $tag->save();

        return redirect('/tags');
    }

    public function destroy(string $id): RedirectResponse
    {
        Tag::find($id)->delete();

        return redirect('/tags');
    }

    public function edit(string $id)
    {
        $tag = Tag::find($id);

        return view('tags.edit', [
            'tag' => $tag,
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['hex_color'],
        ]);

        $tag = Tag::find($id);

        $tag->name = $request->name;
        $tag->color = $request->color;

        $tag->save();

        return redirect('/tags');
    }
}
