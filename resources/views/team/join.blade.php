@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;
    use App\Models\Team;

    $current_user = User::find(Auth::id());
    $inviter = User::find($current_user->invited_to_team_by_user) ?? null;
@endphp

@extends('layouts.layout')

@section('content')
    <div class="m-4 p-10 flex text-gray-200 text-lg bg-gray-700 rounded-lg space-x-4">
        @if(empty($current_user->invited_to_team_by_user))
            <h2>You have no pending invitations right now.</h2>
        @else
            <div class="flex space-x-4">
                <h2>You have a pending invitation from {{ $inviter->name }} to join {{ Team::find($inviter->team_id)->name }}</h2>
                <form action="{{ route('team.invite.accept') }}" method="POST">
                    @csrf
                    @method('patch')

                    <x-primary-button>Accept</x-primary-button>
                </form>
                <form action="{{ route('team.invite.decline') }}" method="POST">
                    @csrf
                    @method('patch')

                    <x-primary-button>Decline</x-primary-button>
                </form>
            </div>
        @endif
    </div>
@endsection
