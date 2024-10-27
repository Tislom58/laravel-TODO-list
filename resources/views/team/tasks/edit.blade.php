@extends('layouts.layout')

@section('content')
    <div>
        <form id="edit-task" action="{{ route('team.task.update', ['id' => $task->id]) }}" method="POST"
              class="space-x-4">
            @csrf
            @method('put')

            <label>
                <span>Task: </span>
                <input type="text" name="description" class="bg-gray-500 rounded-xl" value="{{ $task->description }}">
            </label>

            <label>
                <span>Due date: </span>
                <input type="date" name="due_date" class="bg-gray-500 rounded-xl" value="{{ $task->due_date }}">
            </label>

            <label>
                <span>Select tags: </span>
                <select multiple name="tags[]" class="bg-gray-500 rounded-xl">
                    @foreach($tags as $tag)
                        <option @if( in_array($tag->id, $tags_of_task) ) selected @endif value="{{ $tag->id }}"
                                style="color: {{ $tag->color }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </label>

            <label for="assignment"></label>

            <span>Assign to: </span>
            <select name="assigned_to[]" id="assignment" multiple class="bg-gray-500 rounded-lg mt-6">
                @foreach($team->members as $member)
                    @php $assigned_users = $task->users->pluck('id')->toArray(); @endphp
                        <option @if( in_array($member->id, $assigned_users) ) selected @endif
                        value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>

            <x-primary-button>Save</x-primary-button>
        </form>
    </div>
@endsection
