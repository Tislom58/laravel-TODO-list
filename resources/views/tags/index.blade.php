@extends('layouts.layout')

@section('content')
<div>
    @foreach($tags as $tag)
        <div class="task p-6 ml-6 max-w-fit bg-gray-500 rounded-xl shadow-md items-center space-x-4" id="{{ $tag->id }}">
            <p style="color: {{ $tag->color }}"> {{ $tag->name }} | {{ $tag->color }}</p>
            <a href="/tags/{{ $tag->id }}/edit"><button>Edit</button></a>
            <form action="/tags/{{ $tag->id }}" method="post">
                @csrf
                @method('delete')
                <input type="submit" value="Delete">
            </form>
        </div>
    @endforeach
    <a href="/tags/create"><button class="p-3 ml-6 mt-3 max-w-fit bg-gray-500 rounded-xl shadow-md items-center space-x-4 hover:bg-red-500">+</button></a>
</div>
@endsection
