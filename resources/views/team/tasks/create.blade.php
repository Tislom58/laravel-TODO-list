@extends('layouts.layout')

@section('content')
<div>
    <form id="add-task" action="{{ route('team.task.store') }}" method="POST" class="space-x-4">
        @csrf

        <label>
            <span>Task description: </span>
            <input type="text" name="description" class="bg-gray-500 rounded-xl">
        </label>

        <label>
            <span>Due date: </span>
            <input type="date" name="due_date" class="bg-gray-500 rounded-xl">
        </label>

        <label>
            <span>Select tags: </span>
            <select multiple name="tags[]" class="bg-gray-500 rounded-xl">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" style="color: {{ $tag->color }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </label>

        <label for="assignment"></label>

        <span>Assign to: </span>
        <select name="assigned_to[]" id="assignment" multiple class="bg-gray-500 rounded-lg mt-6">
            @foreach($team->members as $member)
                <option value="{{ $member->id }}">{{ $member->name }}</option>
            @endforeach
        </select>

        <x-primary-button>Add task</x-primary-button>
    </form>
</div>
@endsection
