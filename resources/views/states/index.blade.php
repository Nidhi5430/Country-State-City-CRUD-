@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>States</h3>
    <a href="{{ route('states.create') }}" class="btn btn-primary">Add State</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>State Name</th>
            <th>Country</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($states as $state)
            <tr>
                <td>{{ $state->id }}</td>
                <td>{{ $state->name }}</td>
                <td>{{ $state->country->name }}</td>
                <td>
                    {{-- Edit --}}
                    <a href="{{ route('states.edit', ['state' => $state->id]) }}" 
                       class="btn btn-sm btn-secondary">
                        Edit
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('states.destroy', ['state' => $state->id]) }}" 
                          method="POST" 
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" 
                                onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- Pagination --}}
{{ $states->links() }}
@endsection
