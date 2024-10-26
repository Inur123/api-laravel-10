@extends('layouts.app')

@section('title', 'Daily Tasks')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <style>
        .truncate {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 200px; /* Adjust as needed */
        }
    </style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daily Task Table</h4>
                            <div class="card-header-action d-flex">
                                <a href="{{ route('daily_tasks.create') }}" class="btn btn-success">Create Daily Task</a>
                            </div>
                        </div>
                        <div class="card-body p-2">
                            @if(session('success'))
                                <div id="global-alert" class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="daily-tasks-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Challenge</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dailyTasks as $index => $task)
                                            <tr>
                                                <td>{{ $index + 1 }}</td> <!-- Displaying serial number -->
                                                <td>{{ $task->challenge->title ?? 'N/A' }}</td> <!-- Displaying related challenge title -->
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
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#daily-tasks-table').DataTable();
        });

        document.addEventListener("DOMContentLoaded", function() {
            var alert = document.getElementById('global-alert');
            if (alert) {
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 3000); // Hide after 3 seconds
            }
        });
    </script>
@endpush
