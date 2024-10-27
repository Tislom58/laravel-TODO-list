@extends('layouts.layout')

@section('content')
<div>
    <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->
    <form action="{{ route('team.tag.store') }}" method="POST">
        @csrf

        <label>
            <span>Tag name: </span>
            <input type="text" name="name">
        </label>

        <label>
            <span>Tag color: </span>
            <input type="color" name="color">
        </label>

        <x-primary-button>Add tag</x-primary-button>

    </form>
</div>
@endsection
