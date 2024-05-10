<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dančilist</title>
    @vite(['resources/css/tasks.css', 'resources/css/app.css'])
</head>
<body class="poetsen-one-regular">
@include('livewire.navbar')

@foreach($archived_tasks as $task)
    <div class="task">
        <br>
        <h2> {{ $task->description }} </h2>
        <h3>{{ $task->due_date }}</h3>
    </div>
@endforeach

</body>
</html>
