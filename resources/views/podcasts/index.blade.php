@extends('layouts.app')

@section('title', 'Podcast Table')

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
                        <div class="card shadow-lg rounded-lg overflow-hidden">
                            <div class="card-header bg-gray-100 flex justify-between items-center p-4">
                                <h4 class="text-lg font-semibold text-gray-700">Podcast Table</h4>
                                <div class="card-header-action d-flex">
                                    <a href="{{ route('podcasts.create') }}" class="btn btn-success">Create Podcast</a>

                                </div>
                            </div>
                            <div class="card-body p-2">
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
                                            @foreach($podcasts as $index => $podcast)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $podcast->title }}</td>
                                                <td class="truncate" title="{{ $podcast->description }}">
                                                    {{ Str::limit($podcast->description, 50, '...') }}
                                                </td>
                                                <td><a href="{{ $podcast->link }}" target="_blank" class="btn btn-link">Listen</a></td>
                                                <td>
                                                    <a href="{{ route('podcasts.edit', $podcast->id) }}" class="btn btn-warning">Edit</a>
                                                    <form action="{{ route('podcasts.destroy', $podcast->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this podcast?')">Delete</button>
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

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/components-table.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#sortable-table').DataTable();
        });
    </script>
@endpush
