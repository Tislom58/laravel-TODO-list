<?php

namespace App\Http\Controllers;

use App\Models\TasksTags;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();

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
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->color = $request->color;

        $tag->save();

        return redirect('/tags');
    }

    public function destroy(string $id): RedirectResponse
    {
        $tag = Tag::find($id);
        $tag->delete();

        $task_tags = TasksTags::where('tag_id', $id)->get();
        foreach($task_tags as $tag)
            $tag->delete();

        return redirect('/tags');
    }

    public function edit(string $id)
    {
        $tag = Tag::where('id', $id)->firstOrFail();

        return view('tags.edit', [
            'tag' => $tag,
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $tag = Tag::where('id', $id)->firstOrFail();

        $tag->name = $request->name;
        $tag->color = $request->color;

        $tag->save();

        return redirect('/tags');
    }
}
