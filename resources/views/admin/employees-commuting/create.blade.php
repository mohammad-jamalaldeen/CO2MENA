@extends('admin.layouts.app')

@section('title')
Create Employees Commuting
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('employees-commuting.index') }}">Employees Commuting</a></li>
    <li class="breadcrumb-item active">Create</li>
</ul>
    <div class="customer-support">
      <form class="input-form" id="employeescommuting-create" method="POST" action="{{ route('employees-commuting.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            {{-- <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label >Row ID</label>
                    <input type="number" name="row_id" placeholder="Row ID" 
                    class="form-controal">
                    @error('row_id')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div> --}}

            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="vehicle">Vehicle <span class="mandatory-field">*</span></label>
            <select name="vehicle" placeholder="Select Vehicle" id="vehicle" data-live-search="true">
                @foreach (\App\Models\EmployeesCommuting::VEHICLE as $value)
                    <option value="{{ $value }}" {{ old('vehicle') == $value ? 'selected' : '' }}>
                        {{ $value }}</option>
                @endforeach
            </select>
                    @error('vehicle')
                    <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="type">Type <span class="mandatory-field">*</span></label>
                    <select class="col-md-4 col-12" placeholder="Select Type" name="type" id="type" data-live-search="true">
                @foreach (\App\Models\EmployeesCommuting::TYPE as $value)
                    <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
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
                    <select class="col-md-4 col-12" name="fuel" placeholder="Select Fuel" id="fuel" data-live-search="true">
                @foreach (\App\Models\EmployeesCommuting::FUEL as $value)
                    <option value="{{ $value }}" {{ old('fuel') == $value ? 'selected' : '' }}>
                        {{ $value }}</option>
                @endforeach
            </select>
                    @error('fuel')
                    <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="unit">Unit <span class="mandatory-field">*</span></label>
                    <select class="col-md-4 col-12" placeholder="Select Unit" name="unit" id="unit" data-live-search="true">
                @foreach (\App\Models\EmployeesCommuting::UNIT as $value)
                    <option value="{{ $value }}" {{ old('unit') == $value ? 'selected' : '' }}>
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
                    <label for="factors">Emission Factor  <span class="mandatory-field">*</span></label>
                    <input type="text" name="factors" id="factors" placeholder="Enter Emission Factor" 
                    class="form-controal">
                    @error('factors')
                    <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12" style="display: none;">
                <div class="form-group">
                    <label for="total_distance">Total Distance</label>
                    <input type="text" name="total_distance" id="total_distance" placeholder="Total Distance" class="form-control" value="0">
                    @error('total_distance')
                    <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label >Formula</label>
                    <input type="text" name="formula" placeholder="Formula" 
                    class="form-controal">
                    @error('formula')
                    <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div> --}}

            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{route('employees-commuting.index')}}" title="cancel" class="back-btn">Cancel</a>
                    <button type="submit" class="btn-primary" title="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection
@section('footer_scripts')
@endsection
