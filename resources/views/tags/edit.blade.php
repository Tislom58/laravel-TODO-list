@extends('layouts.layout')

@section('content')
    <div>
        <form action="/tags/{{ $tag->id }}" method="post">
            @csrf
            @method('put')

            <div class="task" id="{{ $tag->id }}">
                <input type="text" name="name" value="{{ $tag->name }}">
                <p> | </p>
                <input type="color" name="color" value="{{ $tag->color }}">

                <x-input-error :messages="$errors->all()" class="mt-2" />
                <input type="submit" value="Save">
            </div>
        </form>
    </div>
@endsection
