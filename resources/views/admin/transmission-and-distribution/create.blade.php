@extends('admin.layouts.app')
@section('title')
 @if(isset($transmission_and_distribution)) Edit @else Create @endif
 Transmission And Distribution
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('transmission-and-distribution.index') }}">Transmission And Distribution Management</a></li>
    @if(isset($transmission_and_distribution))
    <li class="breadcrumb-item active">Edit</li>
    @else
    <li class="breadcrumb-item active">Create</li>
    @endif
</ul>
<div class="customer-support">
    @if(isset($transmission_and_distribution))
    <form action="{{ route('transmission-and-distribution.update', $transmission_and_distribution->id) }}" enctype="multipart/form-data" method="post" class="input-form">
    @csrf
    @else
    <form action="{{ route('transmission-and-distribution.store') }}" enctype="multipart/form-data" method="post" class="input-form">
    @csrf
    @endif
        <div class="row">
            {{-- <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="row_id">Row ID</label>
                    <input type="number" name="row_id" id="row_id" value="@if(isset($transmission_and_distribution)){{ $transmission_and_distribution->row_id }}@else{{ old('row_id') }}@endif" placeholder="Enter Row ID" class="form-controal">
                    @error('row_id')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>   --}}
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="activity">Activity <span class="mandatory-field">*</span></label>
                    <input type="text" name="activity" id="activity" value="@if(isset($transmission_and_distribution)){{ $transmission_and_distribution->activity }}@else{{ old('activity') }}@endif" placeholder="Enter Activity" class="form-controal">
                    @error('activity')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="unit">Unit <span class="mandatory-field">*</span></label>
                    {{-- <input type="text" name="unit" id="unit" value="@if(isset($transmission_and_distribution)){{ $transmission_and_distribution->unit }}@else{{ old('unit') }}@endif" placeholder="Enter Unit" class="form-controal"> --}}
                    <select name="unit" id="unit" placeholder="Select Unit" data-live-search="true">
                        <option value="">Select Unit</option>
                        @foreach (\App\Models\TransmissionAndDistribution::UNIT as $key => $value)
                            @if(!empty($transmission_and_distribution))
                                @if($transmission_and_distribution->unit == $value)
                                @php $selected = "selected";@endphp
                                @else
                                @php $selected = "";@endphp
                                @endif
                            @else
                                @if ($key == 0)
                                    @php $selected = "selected";@endphp
                                @else
                                    @php $selected = "";@endphp
                                @endif
                            @endif
                            <option {{$selected}} value="{{ $value }}">{{ $value }}</option>
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
                        <input type="text" id="factors" name="factors" class="form-controal" value="@if(isset($transmission_and_distribution)){{ $transmission_and_distribution->factors }}@else{{ old('factors') }}@endif" placeholder="Enter Emission Factor">
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
                        <input type="text" id="formula" name="formula" class="form-controal" value="@if(isset($transmission_and_distribution)){{ $transmission_and_distribution->formula }}@else{{ old('formula') }}@endif" placeholder="Enter Formula">
                        @error('formula')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>  
            </div> --}}
            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{route('transmission-and-distribution.index')}}" class="back-btn" title="cancel">Cancel</a>
                    <button type="submit" class="btn-primary" title="submit">Submit</button>
                </div>
            </div>
            
        </div>
        
    </form>
</div>
@endsection
@section('footer_scripts')

@endsection