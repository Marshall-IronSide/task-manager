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
                    <small>Created: </small>
                </p>
            </div>
        @endforelse
    </div>
