@extends('admin.layouts.app')
@section('title')
@if(isset($fuels)) Edit @else Create @endif
Fuel
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fuels.index') }}">Fuel Management</a></li>
    @if(isset($fuels))
    <li class="breadcrumb-item active">Edit</li>
    @else
    <li class="breadcrumb-item active">Create</li>
    @endif
</ul>
<div class="customer-support">
    @if(isset($fuels))
    <form action="{{ route('fuels.update', $fuels->id) }}" enctype="multipart/form-data" method="post" class="input-form">
    @csrf
    @else
    <form action="{{ route('fuels.store') }}" enctype="multipart/form-data" method="post" class="input-form">
    @csrf
    @endif
        <div class="row">
            {{-- <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="row_id">Row ID</label>
                    <input type="number" name="row_id" id="row_id" value="@if(isset($fuels)){{ $fuels->row_id }}@else{{ old('row_id') }}@endif" placeholder="Enter Row ID" class="form-controal">
                    @error('row_id')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>   --}}
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="type">Type <span class="mandatory-field">*</span></label>
                    {{-- <input type="text" name="type" id="type" value="@if(isset($fuels)){{ $fuels->type }}@else{{ old('type') }}@endif" placeholder="Enter Type" class="form-controal"> --}}
                    <select name="type" placeholder="Select Type" id="type" data-live-search="true">
                        @foreach (\App\Models\Fuels::TYPE as $value)
                            <option value="{{ $value }}"
                            @if(isset($fuels) && $fuels->type === $value) selected @elseif(old('type') == $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="fuel">Fuel <span class="mandatory-field">*</span></label>
                    <input type="text" name="fuel" id="fuel" value="@if(isset($fuels)){{ $fuels->fuel }}@else{{ old('fuel') }}@endif" placeholder="Enter Fuel" class="form-controal">
                    @error('fuel')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="unit">Unit <span class="mandatory-field">*</span></label>
                    {{-- <input type="text" name="unit" id="unit" value="@if(isset($fuels)){{ $fuels->unit }}@else{{ old('unit') }}@endif" placeholder="Enter Unit" class="form-controal"> --}}
                    <select name="unit" id="unit" placeholder="Select Unit" data-live-search="true">
                        @foreach (\App\Models\Fuels::UNIT as $value)
                            <option value="{{ $value }}"
                            @if(isset($fuels) && $fuels->unit == $value) selected @elseif(old('unit') == $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('unit')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4  col-sm-6 col-12">
                <div class="form-group">
                    <label for="factor">Emission Factor <span class="mandatory-field">*</span></label>
                    <input type="text" name="factor"  id="factor" value="@if(isset($fuels)){{ $fuels->factor }}@else{{ old('factor') }}@endif" placeholder="Enter Emission Factor" class="form-controal">
                    @error('factor')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="formula">Formula</label>
                    <div class="input-group">
                        <input type="text" id="formula" name="formula" class="form-controal" value="@if(isset($fuels)){{ $fuels->formula }}@else{{ old('formula') }}@endif" placeholder="Enter Formula">
                        @error('formula')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>  
            </div> --}}

            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{route('fuels.index')}}" class="back-btn" title="cancel">Cancel</a>
                    <button type="submit" class="btn-primary" title="submit">Submit</button>
                </div>
            </div>
            
        </div>
        
    </form>
</div>
@endsection
@section('footer_scripts')

@endsection