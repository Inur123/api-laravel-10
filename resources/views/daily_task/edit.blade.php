@extends('layouts.app')

@section('title', 'Edit Daily Task')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Daily Task</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('daily_tasks.update', $dailyTask->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="challenge_id">Challenge</label>
                                    <select name="challenge_id" id="challenge_id" class="form-control" required>
                                        <option value="">Select Challenge</option>
                                        @foreach($challenges as $challenge)
                                            <option value="{{ $challenge->id }}" {{ $dailyTask->challenge_id == $challenge->id ? 'selected' : '' }}>
                                                {{ $challenge->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" rows="5" class="form-control">{{ $dailyTask->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update Daily Task</button>
                                    <a href="{{ route('daily_tasks.index') }}" class="btn btn-secondary">Cancel</a>
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
