@extends('layouts.app')

@section('content')
<h3>Edit City</h3>

<form action="{{ route('cities.update', $city) }}" method="POST" id="cityForm">
  @csrf @method('PUT')

  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Country</label>
      <select name="country_id" id="countrySelect" class="form-select" required>
        <option value="">Choose country</option>
        @foreach($countries as $c)
          <option value="{{ $c->id }}" {{ (old('country_id', $city->state->country_id) == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
        @endforeach
      </select>
      @error('country_id') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label">State</label>
      <select name="state_id" id="stateSelect" class="form-select" required>
        <option value="">Choose state</option>
        @foreach($states as $s)
          <option value="{{ $s->id }}" {{ (old('state_id', $city->state_id) == $s->id) ? 'selected' : '' }}>{{ $s->name }}</option>
        @endforeach
      </select>
      @error('state_id') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="mb-3">
    <label class="form-label">City Name</label>
    <input name="name" value="{{ old('name', $city->name) }}" class="form-control" required>
    @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
  </div>

  <button class="btn btn-primary">Update</button>
  <a class="btn btn-secondary" href="{{ route('cities.index') }}">Cancel</a>
</form>
@endsection

@push('scripts')
<script>
$(function() {
  function loadStates(countryId, selectedStateId = null) {
    $('#stateSelect').html('<option value="">Loading...</option>');
    if (!countryId) {
      $('#stateSelect').html('<option value="">Choose state</option>');
      return;
    }
    $.ajax({
      url: '/ajax/states/' + countryId,
      method: 'GET',
      success: function(data) {
        let html = '<option value="">Choose state</option>';
        data.forEach(function(s) {
          html += `<option value="${s.id}" ${selectedStateId==s.id ? 'selected' : ''}>${s.name}</option>`;
        });
        $('#stateSelect').html(html);
      },
      error: function() {
        $('#stateSelect').html('<option value="">Error loading states</option>');
      }
    });
  }

  const initialCountry = $('#countrySelect').val();
  const initialState = "{{ old('state_id', $city->state_id) }}";
  if (initialCountry) {
    loadStates(initialCountry, initialState || null);
  }

  $('#countrySelect').on('change', function() {
    loadStates($(this).val());
  });
});
</script>
@endpush
