@extends('layouts.app')

@section('content')
<h3>Add State</h3>

<form action="{{ route('states.store') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label class="form-label">Country</label>
    <select name="country_id" class="form-select" required>
      <option value="">Choose country</option>
      @foreach($countries as $c)
        <option value="{{ $c->id }}" {{ old('country_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
      @endforeach
    </select>
    @error('country_id') <div class="text-danger mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">State Name</label>
    <input name="name" value="{{ old('name') }}" class="form-control" required>
    @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
  </div>

  <button class="btn btn-primary">Save</button>
  <a class="btn btn-secondary" href="{{ route('states.index') }}">Cancel</a>
</form>
@endsection
