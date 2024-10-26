@extends('layouts.app')

@section('title', 'Daily Tasks')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daily Tasks</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('daily_tasks.create') }}" class="btn btn-primary">Create Daily Task</a>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th> <!-- Kolom nomor urut -->
                                        <th>Challenge</th> <!-- Menampilkan challenge terkait -->
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dailyTasks as $index => $task)
                                        <tr>
                                            <td>{{ $index + 1 }}</td> <!-- Menampilkan nomor urut -->
                                            <td>{{ $task->challenge->title ?? 'N/A' }}</td> <!-- Menampilkan judul challenge terkait -->
                                            <td class="truncate" title="{{ $task->description }}">
                                                {{ Str::limit($task->description, 50, '...') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('daily_tasks.edit', $task->id) }}" class="btn btn-warning">Edit</a>
                                                <form action="{{ route('daily_tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
