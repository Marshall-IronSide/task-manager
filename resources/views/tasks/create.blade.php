@extends('layouts.app')

@section('content')
    <h1>Create New task</h1>
    <form action="{{route('tasks.store')}}" method="POST">
        @csrf
        <label>Title:</label>
        <input type="text" name="Title" value="{{old('title')}}" required>
        @error('title')
        <p style="color: red;">{{$message}}</p>
        @enderror
        <label>Description:</label>
        <textarea name="desscription" rows="4">{{old('description')}}</textarea>
        @error('description')
        <p style="color: red;">{{$message}}</p>
        @enderror
        <button type="submit" class="btn">Create Task</button>
        <a href="{{route('tasks.index')}}" class="btn" style="background: #6c757d;">Cancel</a>
    </form>
@endsection
