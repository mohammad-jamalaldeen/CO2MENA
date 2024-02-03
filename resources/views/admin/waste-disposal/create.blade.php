@extends('admin.layouts.app')
@section('title')
    @if (isset($waste_disposal))
        Edit
    @else
        Create
    @endif
    Waste disposal
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('waste-disposal.index') }}">Waste disposal Management</a></li>
        @if (isset($waste_disposal))
            <li class="breadcrumb-item active">Edit</li>
        @else
            <li class="breadcrumb-item active">Create</li>
        @endif
    </ul>
    <div class="customer-support">
        @if (isset($waste_disposal))
            <form action="{{ route('waste-disposal.update', $waste_disposal->id) }}" enctype="multipart/form-data" method="post" class="input-form">
                @csrf
        @else
            <form action="{{ route('waste-disposal.store') }}" enctype="multipart/form-data" method="post" class="input-form">
                @csrf
        @endif
        <div class="row">
            {{-- <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="row_id">Row ID</label>
                        <input type="number" name="row_id" id="row_id" value="@if (isset($waste_disposal)){{ $waste_disposal->row_id }}@else{{ old('row_id') }}@endif" placeholder="Enter Row ID" class="form-controal">
                        @error('row_id')
                        <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="waste_type">Activity <span class="mandatory-field">*</span></label>
                    <input type="text" name="waste_type" id="waste_type"
                        value="@if(isset($waste_disposal)){{ $waste_disposal->waste_type }}@else{{ old('waste_type') }}@endif"
                        placeholder="Enter Activity" class="form-controal">                    
                    @error('waste_type')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="type">Type <span class="mandatory-field">*</span></label>
                    <select name="type" id="type" placeholder="Select Type" data-live-search="true">
                        @foreach (\App\Models\WasteDisposal::TYPE as $value)
                            <option value="{{ $value }}"
                                {{ !empty($waste_disposal) && $waste_disposal->type == $value ? 'selected' : '' }}>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="factors">Emission Factor <span class="mandatory-field">*</span></label>
                    <input type="text" name="factors" id="factors"
                        value="@if(isset($waste_disposal)){{ $waste_disposal->factors }}@else{{ old('factors') }}@endif"
                        placeholder="Enter Emission Factor" class="form-controal">
                    @error('factors')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="formula">Formula</label>
                        <div class="input-group">
                            <input type="text" id="formula" name="formula" class="form-controal" value="@if (isset($waste_disposal)){{ $waste_disposal->formula }}@else{{ old('formula') }}@endif" placeholder="Enter Formula">
                            @error('formula')
                            <span class="error-mgs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div> --}}
            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{ route('waste-disposal.index') }}" class="back-btn" title="cancel">Cancel</a>
                    <button type="submit" class="btn-primary" title="submit">Submit</button>
                </div>
            </div>

        </div>

        </form>
    </div>
@endsection
@section('footer_scripts')
@endsection
