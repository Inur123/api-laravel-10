@extends('layouts.app')

@section('title', 'GirlyPedia Table')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                                <h4>GirlyPedia Table</h4>
                                <div class="card-header-action d-flex">
                                    <a href="{{ route('girlyPedia.create') }}" class="btn btn-success ml-2">Create GirlyPedia Item</a>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                @if (session('success'))
                                    <div id="global-alert" class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div id="global-alert" class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="sortable-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Link</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($girlyPediaItems as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->title }}</td>
                                                    <td class="truncate" title="{{ $item->description }}">
                                                        {{ Str::limit($item->description, 50, '...') }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ $item->link }}" target="_blank" class="btn btn-link">Visit</a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('girlyPedia.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                                        <form action="{{ route('girlyPedia.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
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
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sortable-table').DataTable();
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
