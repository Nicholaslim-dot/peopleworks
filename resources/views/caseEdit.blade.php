@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Edit Case</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('cases.update', $case->id) }}">
        @csrf
        @method('PATCH')

        <div class="row">
            @foreach($case->getAttributes() as $key => $value)
                @if(!in_array($key, ['id','created_at','updated_at']))
                    <div class="col-md-6 mb-3">
                        <label for="{{ $key }}" class="form-label">
                            {{ ucfirst(str_replace('_',' ', $key)) }}
                        </label>

                        {{-- If distinct values exist for this column, render datalist --}}
                        @if(isset($distincts[$key]) && $distincts[$key]->count() > 0)
                            <input list="{{ $key }}Options"
                                   class="form-control"
                                   id="{{ $key }}"
                                   name="{{ $key }}"
                                   value="{{ old($key, $value) }}">
                            <datalist id="{{ $key }}Options">
                                @foreach($distincts[$key] as $option)
                                    <option value="{{ $option }}">
                                @endforeach
                            </datalist>

                        {{-- Textarea for remarks/notes/description --}}
                        @elseif(Str::contains($key, ['remark','notes','description']))
                            <textarea class="form-control"
                                      id="{{ $key }}"
                                      name="{{ $key }}"
                                      rows="3">{{ old($key, $value) }}</textarea>

                        {{-- Smart input types --}}
                        @else
                            @php
                                $inputType = 'text';
                                if (Str::contains($key, ['date'])) {
                                    $inputType = 'date';
                                } elseif (Str::contains($key, ['email'])) {
                                    $inputType = 'email';
                                } elseif (Str::contains($key, ['phone','contact'])) {
                                    $inputType = 'tel';
                                } elseif (Str::contains($key, ['amount','price','number','qty','count'])) {
                                    $inputType = 'number';
                                }
                            @endphp
                            <input type="{{ $inputType }}"
                                   class="form-control"
                                   id="{{ $key }}"
                                   name="{{ $key }}"
                                   value="{{ old($key, $value) }}">
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-success px-4">Update Case</button>
        </div>
    </form>
</div>
@endsection
