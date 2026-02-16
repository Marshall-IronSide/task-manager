@extends('layouts.app')

@section('content')
    <h1>My Tasks</h1>
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    <a href=" {{ route('tasks.create') }} " class="btn">+ New Task</a>
    <div style="margin-top: 20px;">
        @forelse($tasks as $task)
            <div class="task-item {{ $task-> completed ? 'completed' : '' }}">
                <h3>
                    {{$task->title}}
                </h3>
                <p>
                    {{$task-> description}}
                </p>
                <p>
                    <small>Created: {{$task->created_at->diffForHumans()}}</small>
                </p>
                <div style="margin-top:10px;">
                    <a href="{{route('tasks.show', $task)}}" class="btn">View</a>
                    <a href="{{route('tasks.edit', $task)}}" class="btn">Edit</a>
                    <form action="{{route('tasks.destroy', $task)}}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are u sure ?')">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p>No task yet. Create ur first one!</p>
        @endforelse
    </div>
@endsection
