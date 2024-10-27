@extends('layouts.layout')

@section('content')
<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
    <form action="{{ route('team.tag.update', ['id' => $tag->id]) }}" method="POST">
        @csrf
        @method('put')

        <div class="task" id="{{ $tag->id }}">
            <input type="text" name="name" value="{{ $tag->name }}">
            <p> | </p>
            <input type="color" name="color" value="{{ $tag->color }}">
            <x-primary-button>Save</x-primary-button>
        </div>
    </form>
</div>
@endsection
