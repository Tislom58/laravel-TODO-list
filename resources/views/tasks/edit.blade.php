@extends('layouts.layout')

@section('content')
    <div>
        <form action="/tasks/{{ $task->id }}" method="post">
            @csrf
            @method('put')
            @php
                // Obtain tags associated with each task
                $tag_ids = \App\Models\TasksTags::where('task_id', $task->id)->pluck('tag_id');
                $task_tags = [];
                foreach($tag_ids as $tag_id)
                    $task_tags[] = \App\Models\Tag::find($tag_id)->name;

                $tags = \App\Models\Tag::all();
            @endphp
            <div class="task" id="{{ $task->id }}">
                <input type="text" name="description" value="{{ $task->description }}">
                <p> | </p>
                <input type="date" name="due_date" value="{{ $task->due_date }}">

                <select multiple name="tags[]">
                    @foreach($tags as $tag)
{{--                    Display tags and preselect ones that are active --}}
                        @if( in_array($tag->name, $task_tags) )
                            <option selected="selected" style="color: {{ $tag->color }}"> {{ $tag->name }} </option>
                        @else
                            <option style="color: {{ $tag->color }}"> {{ $tag->name }} </option>
                        @endif
                    @endforeach
                </select>
                <input type="submit" value="Save">
            </div>
        </form>
    </div>
@endsection
