@extends('layouts.layout')

@section('content')
<div>
    <h3>Tags:</h3>
    <a href="/tags/create">Create a new tag</a>

    @foreach($tags as $tag)
        <div class="task" id="{{ $tag->id }}">
            <p style="color: {{ $tag->color }}"> {{ $tag->name }} | {{ $tag->color }}</p>
            <a href="/tags/{{ $tag->id }}/edit"><button>Edit</button></a>
            <form action="/tags/{{ $tag->id }}" method="post">
                @csrf
                @method('delete')
                <input type="submit" value="Delete">
            </form>
        </div>
    @endforeach
</div>
@endsection
