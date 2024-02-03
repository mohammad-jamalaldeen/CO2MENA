@extends('admin.layouts.app')
@section('title')
    @if (isset($watersupplytreatment))
        Edit
    @else
        Create
    @endif
    Water Supply Treatment 
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('water-supply-treatment.index') }}">Water Supply Treatment Management</a></li>
        @if (isset($watersupplytreatment))
            <li class="breadcrumb-item active">Edit</li>
        @else
            <li class="breadcrumb-item active">Create</li>
        @endif
    </ul>
    <div class="customer-support">
        @if (isset($watersupplytreatment))
            <form action="{{ route('water-supply-treatment.update', $watersupplytreatment->id) }}" enctype="multipart/form-data"
                method="post" class="input-form">
                @csrf
            @else
                <form action="{{ route('water-supply-treatment.store') }}" enctype="multipart/form-data" method="post"
                    class="input-form">
                    @csrf
        @endif
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    @php
                        $selectedType = request('type');
                    @endphp
                    <label for="type">Type <span class="mandatory-field">*</span></label>
                    {{-- <select name="type" id="type" placeholder="Select Type" class="form-control" data-live-search="true">
                        <option value="1"
                            {{ (isset($watersupplytreatment) && $watersupplytreatment->type == 1) || $selectedType == 1 ? 'selected' : '' }}>
                            Water Supply</option>
                        <option value="2"
                            {{ (isset($watersupplytreatment) && $watersupplytreatment->type == 2) || $selectedType == 2 ? 'selected' : '' }}>
                            Water Treatment</option>
                    </select> --}}
                    <select class="form-control" name="type" id="type">
                        @foreach (\App\Models\Watersupplytreatment::TYPE as $key => $value)
                            <option value="{{ $key }}" {{ (isset($watersupplytreatment) && $watersupplytreatment->type == $key) || old('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input type="hidden" name="type" value="@if (isset($watersupplytreatment)){{ $watersupplytreatment->type }}@else{{$selectedType}}@endif"> --}}
                </div>
            </div>
            {{-- <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="row_id">Row ID</label>
                    <input type="number" name="row_id" id="row_id" value="@if (isset($watersupplytreatment)){{ $watersupplytreatment->row_id }}@else{{ old('row_id') }}@endif" placeholder="Enter Row ID" class="form-controal">
                    @error('row_id')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>  --}}
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="unit">Unit <span class="mandatory-field">*</span></label>
                    {{-- <input type="text" name="unit" id="unit" value="@if (isset($watersupplytreatment)){{ $watersupplytreatment->unit }}@else{{ old('unit') }}@endif" placeholder="Enter Unit" class="form-controal"> --}}
                    <select name="unit" id="unit" placeholder="Select Unit" data-live-search="true">
                        @foreach (\App\Models\Watersupplytreatment::UNIT as $value)
                            <option value="{{ $value }}" @if (isset($watersupplytreatment) && $watersupplytreatment->unit === $value) selected @endif >
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('unit')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="factors">Emission Factor <span class="mandatory-field">*</span></label>
                    <div class="input-group">
                        <input type="text" id="factors" name="factors" class="form-controal"
                            value="@if(isset($watersupplytreatment)){{ $watersupplytreatment->factors }}@else{{ old('factors') }}@endif"
                            placeholder="Enter Emission Factor">
                        @error('factors')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="formula">Formula</label>
                    <div class="input-group">
                        <input type="text" id="formula" name="formula" class="form-controal" value="@if (isset($watersupplytreatment)){{ $watersupplytreatment->formula }}@else{{ old('formula') }}@endif" placeholder="Enter Formula">
                        @error('formula')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>  
            </div> --}}

            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{ route('water-supply-treatment.index') }}" class="back-btn" title="cancel">Cancel</a>
                    <button type="submit" class="btn-primary" title="submit">Submit</button>
                </div>
            </div>

        </div>

        </form>
    </div>
@endsection
@section('footer_scripts')
@endsection
