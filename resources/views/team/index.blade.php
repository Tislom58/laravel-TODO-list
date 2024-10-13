@extends('layouts.layout')

@php
    $users = \App\Models\User::all();
    $current_user = \App\Models\User::find(\Illuminate\Support\Facades\Auth::id());
    $team = \App\Models\Team::find($current_user->team_id);
    $selected_user = Null;
@endphp

@section('content')
    <div class="grid grid-cols-3 h-full text-gray-300 ">
        <div id="col-1" class="p-10 m-3">
            <a href="/team-task/create" class="p-5 text-lg rounded-xl bg-gray-800 hover:bg-gray-500">New task</a>
        </div>
        <div id="col-2" class="p-3 m-3 text-gray-800">
            @foreach($team_tasks as $task)
                <div class="task p-4 ml-6 w-full bg-gray-500 rounded-lg shadow-md items-center block" id="{{ $task->id }}">
                    <div class="space-y-4">
                        <div>
                            <p class="font-bold"> {{ $task->description }}</p>
                            <p class="font-semibold text-xs">{{ $task->due_date }}</p>
                            <p class="font-semibold text-xs mt-2">Created by {{ \App\Models\User::find($task->author_id)->name }}</p>
                        </div>
                        <div id="buttons" class="flex space-x-4">
                            <x-secondary-button id="complete" class="">
                                <form action="{{ route('team.task.complete', ['id' => $task->id]) }}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <input type="submit" value="Complete" class="cursor-pointer">
                                </form>
                            </x-secondary-button>
                            @if(Auth::id() === $task->author_id)
                                <x-secondary-button id="edit" class="normal-case">
                                    <a href="{{ route('team.task.edit', ['id' => $task->id]) }}">Edit</a>
                                </x-secondary-button>
                            @endif
                            <x-secondary-button id="delete">
                                <form action="{{ route('team.task.destroy', ['id' => $task->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="Delete" class="cursor-pointer">
                                </form>
                            </x-secondary-button>
                        </div>
                        <div class="flex space-x-2 font-semibold text-xs">
                            <p>Assigned to: </p>
                            @foreach($task->users as $member)
                                <ul>{{ $member->name }}</ul>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div id="col-3" class="rounded-lg p-10 m-3 shadow-md border-gray-800 bg-gray-700 space-y-10">
            <div class="space-y-3">
                <h1 class="text-2xl font-semibold">Team members:</h1>
                @foreach($team->members as $member)
                    <ul class="p-2 text-lg rounded bg-gray-800">{{ $member->name }}</ul>
                @endforeach
            </div>
            @if( Auth::id() === $team->creator_id )
                <div id="invite" class="w-fit space-y-4">
                    <h2>Invite a new member:</h2>
                    <form method="POST" action="{{ route('team.invite') }}">
                        @csrf

                        <select name="user" id="select_user">
                            @foreach($users as $user)
                                @if($user->name === $current_user->name)
                                    @continue
                                @endif
                                <option value={{ $user->id }}> {{ $user->name }} </option>
                            @endforeach
                        </select>

                        <x-primary-button>Invite</x-primary-button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
