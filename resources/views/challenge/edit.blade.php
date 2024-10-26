@extends('layouts.app')

@section('title', 'Edit Challenge')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Challenge</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('challenges.update', $challenge) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $challenge->title }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" rows="10" class="form-control">{{ $challenge->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Update Challenge</button>
                                    <a href="{{ route('challenges.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
