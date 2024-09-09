@php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts.layout')

@section('content')
    <div>
        <form action="/tasks/{{ $task->id }}" method="post">
            @csrf
            @method('put')
            @php
                // Obtain tags associated with each task
                $task_tags = $task->tags()->pluck('name')->toArray();
                $tags = User::find(Auth::id())->tags;
            @endphp
            <div class="task" id="{{ $task->id }}">
                <input type="text" name="description" value="{{ $task->description }}">
                <p> | </p>
                <input type="date" name="due_date" value="{{ $task->due_date }}">

                <select multiple name="tags[]">
                    @foreach($tags as $tag)
                        {{--                    Display tags and preselect ones that are active --}}
                        @if( in_array($tag->name, $task_tags) )
                            <option selected="selected" style="color: {{ $tag->color }}"> {{ $tag->name }} </option>
                        @else
                            <option style="color: {{ $tag->color }}"> {{ $tag->name }} </option>
                        @endif
                    @endforeach
                </select>
                <input type="submit" value="Save">
            </div>
        </form>
    </div>
@endsection
