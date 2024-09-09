@extends('layouts.layout')

@section('content')
    <div>
        <h1>User ID: {{ Auth::id() }}</h1>
        <h3>Tasks:</h3>

        <a href="/tasks/create">Create a new task</a>

        <form action="/tasks/filter" method="post">
            @csrf
            @method('put')
            <label for="filter">Filter by tags</label>
            <select multiple id="filter" name="filter[]">
                @foreach(\App\Models\User::find(Auth::id())->tags as $tag)
                    <option>{{ $tag->name }}</option>
                @endforeach
            </select>
            <input type="submit" value="Search">
        </form>

        <p>-----------------------------------------------</p>

        @foreach($tasks as $task)
            @php
                // Obtain tags associated with each task
                $tags = $task->tags;
            @endphp
            <div class="task" id="{{ $task->id }}">
                <p> {{ $task->description }} | {{ $task->due_date }}</p>
                <form action="/tasks/{{ $task->id }}" method="post">
                    @csrf
                    @method('patch')
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
