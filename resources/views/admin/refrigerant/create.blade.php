@extends('admin.layouts.app')
@section('title')
@if(isset($refrigerant)) Edit @else Create @endif
Refrigerant
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('refrigerants.index') }}">Management Refrigerant</a></li>
    @if(isset($refrigerant))
    <li class="breadcrumb-item active">Edit</li>
    @else
    <li class="breadcrumb-item active">Create</li>
    @endif
</ul>
<div class="customer-support">
    @if(isset($refrigerant))
    <form action="{{ route('refrigerants.update', $refrigerant->id) }}" enctype="multipart/form-data" method="post" class="input-form">
        @csrf
        @else
        <form action="{{ route('refrigerants.store',Request()->id) }}" enctype="multipart/form-data" method="post" class="input-form">
            @csrf
            @endif
            <div class="row">
                {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="row_id">Row ID</label>
                        <input type="number" name="row_id" id="row_id" value="@if(isset($refrigerant)){{ $refrigerant->row_id }}@else{{ old('row_id') }}@endif" placeholder="Enter Row ID" class="form-controal">
                        @error('row_id')
                        <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="emission">Name <span class="mandatory-field">*</span></label>
                        <input type="text" name="emission" id="emission" value="@if(isset($refrigerant)){{ $refrigerant->emission }}@else{{ old('emission') }}@endif" placeholder="Enter Name" class="form-controal">
                        @error('emission')
                        <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="type">Type <span class="mandatory-field">*</span></label>
                        <select name="type" id="type" placeholder="Select Type" data-live-search="true">
                            @foreach (\App\Models\Refrigerant::TYPE as $value)
                                <option value="{{ $value }}" {{!empty($refrigerant) && $refrigerant->type == $value ?"selected" : ""}}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('type')
                        <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="unit">Unit <span class="mandatory-field">*</span></label>
                        {{-- <input type="text" name="unit" id="unit" value="@if(isset($refrigerant)){{ $refrigerant->unit }}@else{{ old('unit') }}@endif" placeholder="Enter Unit" class="form-controal"> --}}
                        <select name="unit" id="unit" placeholder="Select Unit" data-live-search="true">
                            @foreach (\App\Models\Refrigerant::UNIT as $value)
                                <option value="{{ $value }}" {{!empty($refrigerant) && $refrigerant->unit == $value ?"selected" : ""}}>{{ $value }}</option>
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
                        <input type="text" name="factors" id="factors" value="@if(isset($refrigerant)){{ $refrigerant->factors }}@else{{ old('factors') }}@endif" placeholder="Enter Emission Factor" class="form-controal">
                        @error('factors')
                        <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="formula">Formula</label>
                        <input type="text" name="formula" id="formula" value="@if(isset($refrigerant)){{ $refrigerant->formula }}@else{{ old('formula') }}@endif" placeholder="Enter Formula" class="form-controal">
                        @error('formula')
                        <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
                <div class="col-12">
                    <div class="towbutton-row">
                        <a href="{{route('refrigerants.index',Request()->id)}}" class="back-btn" title="cancel">Cancel</a>
                        <button type="submit" class="btn-primary" title="submit">Submit</button>
                    </div>
                </div>

            </div>

        </form>
</div>
@endsection
@section('footer_scripts')
@endsection