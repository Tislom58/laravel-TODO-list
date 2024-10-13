@extends('layouts.layout')

@section('content')
<div>
    <form id="add-task" action="/tasks" method="POST">
        @csrf

        <label>
            <span>Task: </span>
            <input type="text" name="description" class="bg-gray-500 rounded-xl">
        </label>

        <label>
            <span>Due date: </span>
            <input type="date" name="due_date" class="bg-gray-500 rounded-xl">
        </label>

        <label>
            <span>Tags: </span>
            <select multiple name="tags[]" class="bg-gray-500 rounded-xl">
                @foreach($tags as $tag)
                    <option>{{ $tag->name }}</option>
                @endforeach
            </select>
        </label>

        <input type="submit" value="Add task">

        {{--        @error('description') <em style="color: red; display: block; margin-top: 5px;">{{ $message }}</em>@enderror--}}

    </form>
</div>
@endsection
