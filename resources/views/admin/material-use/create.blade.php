@extends('admin.layouts.app')
@section('title')
 @if(isset($material_use)) Edit @else Create @endif
 Material Use
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('material-use.index') }}">Material Use Management</a></li>
    @if(isset($material_use))
    <li class="breadcrumb-item active">Edit</li>
    @else
    <li class="breadcrumb-item active">Create</li>
    @endif
</ul>
<div class="customer-support">
    @if(isset($material_use))
    <form action="{{ route('material-use.update', $material_use->id) }}" enctype="multipart/form-data" method="post" class="input-form">
    @csrf
    @else
    <form action="{{ route('material-use.store') }}" enctype="multipart/form-data" method="post" class="input-form">
    @csrf
    @endif
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="activity">Activity <span class="mandatory-field">*</span></label>
                    {{-- <input type="text" name="activity" id="activity" value="@if(isset($material_use)){{ $material_use->activity }}@else{{ old('activity') }}@endif" placeholder="Enter Activity" class="form-controal"> --}}
                    <select name="activity" id="activity" placeholder="Select Activity" data-live-search="true">
                        @foreach (\App\Models\MaterialUse::ACTIVITY as $value)
                            @if(!empty($material_use))
                                @if($material_use->activity == $value)
                                @php $selected = "selected";@endphp
                                @else
                                @php $selected = "";@endphp
                                @endif
                            @else
                            @php $selected = "";@endphp
                            @endif
                            <option {{$selected}} value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('activity')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="waste_type">Waste Type <span class="mandatory-field">*</span></label>
                    <input type="text" name="waste_type" id="waste_type" value="@if(isset($material_use)){{ $material_use->waste_type }}@else{{ old('waste_type') }}@endif" placeholder="Enter Waste Type" class="form-controal">
                    @error('waste_type')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="factors">Emission Factor <span class="mandatory-field">*</span></label>
                    <input type="text" name="factors" id="factors" value="@if(isset($material_use)){{ $material_use->factors }}@else{{ old('factors') }}@endif" placeholder="Enter Emission Factor" class="form-controal">
                    @error('factors')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{route('material-use.index')}}" class="back-btn" title="cancel">Cancel</a>
                    <button type="submit" class="btn-primary" title="submit">Submit</button>
                </div>
            </div>
            
        </div>
        
    </form>
</div>
@endsection
@section('footer_scripts')

@endsection