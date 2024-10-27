@php use Illuminate\Support\Facades\Auth;
     use Illuminate\Support\Facades\DB;
     use \App\Models\User; @endphp
@extends('layouts.layout')

@section('content')
    <div class="grid grid-cols-3 h-full text-gray-300 ">
        <div id="col-1" class="p-3 m-3">
            <h1 class="text-2xl font-semibold justify-self-center">Tags</h1>
            @foreach( $team_tags as $tag )
                <div class="task p-4 ml-6 w-full bg-gray-500 rounded-lg shadow-md items-center grid grid-cols-2"
                     id="{{ $tag->id }}">
                    {{-- Left column --}}
                    <div class="space-y-4 block">
                            <p class="font-bold" style="color: {{ $tag->color }}"> {{ $tag->name }}</p>
                            <p class="font-semibold text-xs mt-2">
                                Created by {{ User::find($tag->author_id)->name }}</p>
                    </div>
                    {{-- Right column --}}
                    <div id="buttons" class="flex justify-end space-x-4">
                        @if(Auth::id() === $tag->author_id)
                            <x-secondary-button id="edit" class="normal-case">
                                <a href="{{ route('team.tag.edit', ['id' => $tag->id]) }}">Edit</a>
                            </x-secondary-button>
                        @endif
                        <x-secondary-button id="delete">
                            <form action="{{ route('team.tag.destroy', ['id' => $tag->id]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <input type="submit" value="Delete" class="cursor-pointer">
                            </form>
                        </x-secondary-button>
                    </div>
                </div>
            @endforeach

            <a href="{{ route('team.tag.create') }}" class="p-5 text-lg text-gray-300 rounded-xl bg-gray-800 hover:bg-gray-500 block ml-6 mt-5 w-full">
                New tag
            </a>
        </div>



        <div id="col-2" class="p-3 m-3 text-gray-800">
            <h1 class="text-2xl font-semibold justify-self-center text-gray-300">Tasks</h1>
            @foreach( $team_tasks as $task )
                @php
                    $team_task_user = DB::table('team_task_user')
                    ->where('user_id', Auth::id())
                    ->where('team_task_id', $task->id)
                    ->first();
                @endphp
                <div class="task p-4 w-full bg-gray-500 rounded-lg shadow-md items-center block"
                     id="{{ $task->id }}">
                    <div class="space-y-4">
                        <div>
                            <p class="font-bold"> {{ $task->description }}</p>
                            <p class="font-semibold text-xs">{{ $task->due_date }}</p>
                            <div class="flex space-x-1 font-semibold text-xs">
                                @foreach( $task->tags as $tag )
                                    <p style="color: {{ $tag->color }};">{{ $tag->name }}</p>
                                @endforeach
                            </div>
                            <p class="font-semibold text-xs mt-2">Created
                                by {{ User::find($task->author_id)->name }}</p>
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
                            @foreach( $task->users as $member )
                                <ul>{{ $member->name }}</ul>
                            @endforeach
                        </div>
                        <div id="reminder" class="flex space-x-2 font-semibold text-xs items-center">
                            <p>Remind me by: </p>
                            {{-- Toggle email reminder --}}
                            <form action="{{ route('team.toggle-email-reminder', ['id' => $task->id]) }}" method="POST">
                                @csrf
                                @method('patch')
                                @if( isset($team_task_user->email_reminder) )
                                    <button type="submit"
                                            class="bg-gray-300 text-gray-800 p-2 rounded-lg hover:bg-gray-400">
                                        Email
                                    </button>
                                @else
                                    <button type="submit"
                                            class="bg-gray-800 text-gray-300 p-2 rounded-lg hover:bg-gray-700">
                                        Email
                                    </button>
                                @endif
                            </form>
                            {{-- Toggle push reminder --}}
                            <form action="{{ route('team.toggle-push-reminder', ['id' => $task->id]) }}" method="POST">
                                @csrf
                                @method('patch')
                                @if( isset($team_task_user->push_reminder) )
                                    <button type="submit"
                                            class="bg-gray-300 text-gray-800 p-2 rounded-lg hover:bg-gray-400">
                                        Push
                                    </button>
                                @else
                                    <button type="submit"
                                            class="bg-gray-800 text-gray-300 p-2 rounded-lg hover:bg-gray-700">
                                        Push
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            <a href="{{ route('team.task.create') }}" class="p-5 text-lg text-gray-300 rounded-xl bg-gray-800 hover:bg-gray-500 block mt-5 w-full">New task</a>
        </div>



        <div id="col-3" class="rounded-lg p-10 m-3 shadow-md border-gray-800 bg-gray-700 space-y-10">
            <div class="space-y-3">
                <h1 class="text-2xl font-semibold">Team members</h1>
                @foreach( $team->members as $member )
                    <ul class="p-2 text-lg rounded bg-gray-800">{{ $member->name }} @if( $member->id === $team->author_id ) (Author) @endif </ul>
                @endforeach
            </div>
            @if( Auth::id() === $team->author_id )
                <div id="invite" class="w-fit space-y-4">
                    <h2>Invite a new member:</h2>
                    <form method="POST" action="{{ route('team.invite') }}">
                        @csrf
                        <label for="invite"></label>
                        <input type="email" name="user_email" id="invite" placeholder="Enter user's email address" class="text-gray-800">
                        <x-input-error :messages="$errors->all()" class="mt-2" />

                        <x-primary-button>Invite</x-primary-button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
