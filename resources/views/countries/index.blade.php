@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Countries</h3>
  <a href="{{ route('countries.create') }}" class="btn btn-primary">Add Country</a>
</div>

<table class="table table-striped">
  <thead><tr><th>S.No.</th><th>Name</th><th>ISO</th><th>Actions</th></tr></thead>
  <tbody>
    @foreach($countries as $country)
      <tr>
        <td>{{ $country->id }}</td>
        <td>{{ $country->name }}</td>
        <td>{{ $country->iso_code }}</td>
        <td>
          <a class="btn btn-sm btn-secondary" href="{{ route('countries.edit', $country) }}">Edit</a>
          <form action="{{ route('countries.destroy', $country) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Delete country and all its states & cities?');">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

{{ $countries->links() }}
@endsection
