@extends('layouts.layout')

@section('content')
<div>
    <h3>Tasks:</h3>

    <a href="/tasks/create">Create a new task</a>
    <a href="/tags">Tags</a>

    <a href="/tasks"><button>Cancel filter</button></a>

    <p>-----------------------------------------------</p>

    @foreach($tasks as $task)
        @php
            // Obtain tags associated with each task
            $tag_ids = \App\Models\TasksTags::where('task_id', $task->id)->pluck('tag_id');
            $tags = [];
            foreach($tag_ids as $tag_id)
                $tags[] = \App\Models\Tag::find($tag_id);
        @endphp
        <div class="task" id="{{ $task->id }}">
            <p> {{ $task->description }} | {{ $task->due_date }}</p>
            <form action="/tasks/{{ $task->id }}" method="post">
                @csrf
                @method('put')
                <input type="submit" value="Complete">
            </form>
            <a href="/tasks/{{ $task->id }}/edit">
                <button>Edit</button>
            </a>
            <form action="/tasks/{{ $task->id }}" method="post">
                @csrf
                @method('delete')
                <input type="submit" value="Delete">
            </form>

            @foreach($tags as $tag)
                <p style="color: {{ $tag->color }}"> {{ $tag->name }} </p>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
