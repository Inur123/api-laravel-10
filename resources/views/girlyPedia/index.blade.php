@extends('layouts.app')

@section('title', 'Manage GirlyPedia')

@section('header', 'Manage GirlyPedia')

@section('content')
    <a href="{{ route('girlyPedia.create') }}" class="bg-green-500 text-white p-2 rounded">Add New Item</a>

    <table class="min-w-full mt-4 border">
        <thead>
            <tr>
                <th class="py-2 border-b">Title</th>
                <th class="py-2 border-b">Description</th>
                <th class="py-2 border-b">Link</th>
                <th class="py-2 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($girlyPediaItems as $item)
                <tr>
                    <td class="py-2 border-b">{{ $item->title }}</td>
                    <td class="py-2 border-b">{{ $item->description }}</td>
                    <td class="py-2 border-b">
                        <a href="{{ $item->link }}" target="_blank" class="text-blue-600">Link</a>
                    </td>
                    <td class="py-2 border-b">
                        <a href="{{ route('girlyPedia.edit', $item->id) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('girlyPedia.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
