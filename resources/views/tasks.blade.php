<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dančilist</title>
        @vite(['resources/css/tasks.css', 'resources/css/app.css'])
    </head>
    <body class="poetsen-one-regular">
        @include('livewire.navbar')

        <form id="add-task" method="POST" action="/tasks">
            @csrf

            <label for="new-task">Task description: </label>
            <input id="new-task" type="text" name="task_description"
                   class="@error('new-task') is-invalid @enderror">

            <label for="task-due-date">Due date: </label>
            <input id="task-due-date" type="date" name="task_due_date">

            <label for="submit"></label>
            <input id="submit" type="submit" value="Add task">

            @error('new-task')
            <div class="alert alert-danger">Wrong input!</div>
            @enderror

        </form>

        @foreach($tasks as $task)
            <div class="task">
                <br>
                @include('livewire.task-handler')
                <h2> {{ $task->description }} </h2>
                <h3>{{ $task->due_date }}</h3>
            </div>
        @endforeach

    </body>
</html>
