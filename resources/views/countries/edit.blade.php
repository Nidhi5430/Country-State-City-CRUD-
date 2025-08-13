@extends('layouts.app')

@section('content')
<h3>Edit Country</h3>

<form action="{{ route('countries.update', $country) }}" method="POST">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input name="name" value="{{ old('name', $country->name) }}" class="form-control" required>
    @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">ISO Code</label>
    <input name="iso_code" value="{{ old('iso_code', $country->iso_code) }}" class="form-control">
    @error('iso_code') <div class="text-danger mt-1">{{ $message }}</div> @enderror
  </div>

  <button class="btn btn-primary">Update</button>
  <a class="btn btn-secondary" href="{{ route('countries.index') }}">Cancel</a>
</form>
@endsection
