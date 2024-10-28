@extends('layouts.layout')

@section('content')
<div>
    <form method="POST" action="{{ route('team.index') }}" class="m-3 space-y-6">
        @csrf

        <div>
            <x-input-label for="create_new_team" :value="__('Team name')" />
            <x-text-input id="create_new_team" name="team_name" type="text" class="mt-1 block" />
            <x-input-error :messages="$errors->all()" class="mt-2" />
        </div>

        <div>
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</div>
@endsection
