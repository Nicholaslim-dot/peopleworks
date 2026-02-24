@extends('layouts.app')

@section('content')
  <h2 class="mb-4">Case Report Search</h2>

  <div class="form-section">
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="caseId">Enter Case ID :</label>
        <input type="text" class="form-control" id="caseId">
      </div>
      <div class="form-group col-md-2">
        <button type="button" class="btn btn-primary mt-4" id="searchBtn">Search</button>
      </div>
    </div>
  </div>

  <ul class="nav nav-tabs" id="woTabs"></ul>
  <div class="tab-content" id="woTabContent"></div>
  <div id="reportOutput" class="mt-4"></div>
@endsection

@push('scripts')
  @vite('resources/js/form.js')
@endpush
