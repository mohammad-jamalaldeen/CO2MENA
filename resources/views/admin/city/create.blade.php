@extends('admin.layouts.app')
@section('title')
     @if (isset($city))
        Edit
    @else
        Create
    @endif 
    City
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('city.index') }}">City Management</a></li>
        @if (isset($city))
            <li class="breadcrumb-item active">Edit</li>
        @else
            <li class="breadcrumb-item active">Create</li>
        @endif
    </ul>
    <div class="customer-support">
        @if (isset($city))
            <form action="{{ route('city.update', $city->id) }}" enctype="multipart/form-data" method="post"
                class="input-form">
                @csrf
        @else
            <form action="{{ route('city.store') }}" enctype="multipart/form-data" method="post" class="input-form">
            @csrf
        @endif
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="name">Origin (city or IATA code) <span class="mandatory-field">*</span></label>
                    <input type="text" name="name" id="name"
                        value="@if(isset($city)){{ $city->name }}@else{{ old('name') }}@endif"
                        placeholder="Enter City" class="form-controal" minlength="3">
                    @error('name')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{ route('city.index') }}" class="back-btn">Cancel</a>
                    <button type="submit" title="submit" class="btn-primary" href="">Submit</button>
                </div>
            </div>

        </div>

        </form>
    </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/char-length-validation.js') }}"></script>
@endsection
