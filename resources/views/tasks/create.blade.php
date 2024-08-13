@extends('layouts.layout')

@section('content')
<div>
    <form id="add-task" action="/tasks" method="POST">
        @csrf

        <label>
            <span>Task: </span>
            <input type="text" name="description">
        </label>

        <label>
            <span>Due date: </span>
            <input type="date" name="due_date">
        </label>

        <label>
            <span>Tags: </span>
            <select multiple name="tags[]">
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
