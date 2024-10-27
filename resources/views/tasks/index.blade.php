@extends('layouts.layout')

@section('content')
    <div>
        <form action="/tasks/filter" method="POST">
            @csrf
            @method('put')
            <label for="filter">Filter by tags</label>
            <select multiple id="filter" name="filter[]" class="bg-gray-500 rounded-xl mt-6">
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
            <div class="task p-6 ml-6 max-w-fit bg-gray-500 rounded-xl shadow-md items-center space-x-4 block" id="{{ $task->id }}">
                <div class="flex space-x-4">
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
                </div>
                <div class="flex space-x-4">
                    @foreach($tags as $tag)
                        <p style="color: {{ $tag->color }}" class="font-light"> {{ $tag->name }} </p>
                    @endforeach
                </div>
            </div>
        @endforeach
        <a href="/tasks/create"><button class="p-3 ml-6 mt-3 max-w-fit bg-gray-500 rounded-xl shadow-md items-center space-x-4 hover:bg-red-500">+</button></a>
    </div>
@endsection
