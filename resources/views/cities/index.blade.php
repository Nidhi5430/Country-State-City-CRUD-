@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Cities</h3>
  <a href="{{ route('cities.create') }}" class="btn btn-primary">Add City</a>
</div>

<table class="table table-striped">
  <thead><tr><th>S.No.</th><th>City</th><th>State</th><th>Country</th><th>Actions</th></tr></thead>
  <tbody>
    @foreach($cities as $city)
      <tr>
        <td>{{ $city->id }}</td>
        <td>{{ $city->name }}</td>
        <td>{{ $city->state->name }}</td>
        <td>{{ $city->state->country->name }}</td>
        <td>
          <a class="btn btn-sm btn-secondary" href="{{ route('cities.edit', $city) }}">Edit</a>
          <form action="{{ route('cities.destroy', $city) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Delete city?');">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

{{ $cities->links() }}
@endsection
