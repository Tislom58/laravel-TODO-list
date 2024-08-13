@extends('layouts.layout')

@section('content')
<div>
    <form id="add-tag" action="/tags" method="POST">
        @csrf

        <label>
            <span>Tag name: </span>
            <input type="text" name="name">
        </label>

        <label>
            <span>Tag color: </span>
            <input type="color" name="color">
        </label>

        <input type="submit" value="Add tag">

    </form>
</div>
@endsection
