@extends('admin.layouts.app')
@section('title')
     @if (isset($vehicles))
        Edit
    @else
        Create
    @endif
    Vehicle
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}">Management Vehicle</a></li>
        @if (isset($vehicles))
            <li class="breadcrumb-item active">Edit</li>
        @else
            <li class="breadcrumb-item active">Create</li>
        @endif
    </ul>
    <div class="customer-support">
        @if (isset($vehicles))
            <form action="{{ route('vehicles.update', $vehicles->id) }}" enctype="multipart/form-data" method="post"
                class="input-form" id="vehicle-form">
                @csrf
            @else
                <form action="{{ route('vehicles.store') }}" enctype="multipart/form-data" method="post"
                    class="input-form" id="vehicle-form">
                    @csrf
        @endif
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    
                    <label for="vehicle_type">Vehicle Type <span class="mandatory-field">*</span></label>
                    {{-- <select name="vehicle_type" id="vehicle_type" class="form-control" data-live-search="true">
                        <option value="1" {{ old('vehicle_type', isset($vehicles) && $vehicles->vehicle_type == 1) ? 'selected' : '' }}>Passenger Vehicles</option>
                        <option value="2" {{ old('vehicle_type', isset($vehicles) && $vehicles->vehicle_type == 2) ? 'selected' : '' }}>Delivery Vehicles</option>
                    </select> --}}
                    <select class="form-control" name="vehicle_type" id="vehicle_type">
                        @foreach (\App\Models\Vehicle::VEHICLE_TYPE as $key => $value)
                            <option value="{{ $key }}" {{ (isset($vehicles) && $vehicles->vehicle_type == $key) || old('vehicle_type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="row_id">Row ID</label>
                        <input type="number" name="row_id" id="row_id" value="@if (isset($vehicles)){{ $vehicles->row_id }}@else{{ old('row_id') }}@endif" placeholder="Enter Row ID" class="form-controal">
                        @error('row_id')
                        <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
            <div class="col-md-4 col-sm-6 col-12 id_field">
                <div class="form-group">
                    <label for="vehicle">Vehicle <span class="mandatory-field">*</span></label>
                    {{-- <input type="text" name="vehicle" id="vehicle" value="@if (isset($vehicles)){{ $vehicles->vehicle }}@else{{ old('vehicle') }}@endif" placeholder="Enter Vehicle" class="form-controal"> --}}
                    <select name="vehicle" id="vehicle" placeholder="Select Vehicle" data-live-search="true">
                        @foreach (\App\Models\Vehicle::VEHICLE as $value)
                            <option value="{{ $value }}" @if ((isset($vehicles) && $vehicles->vehicle === $value) || old('vehicle') === $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('vehicle')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12 delivery_vehicle_field">
                <div class="form-group">
                    <label for="delivery">Vehicle <span class="mandatory-field">*</span></label>
                    <select name="vehicle" id="delivery" placeholder="Select Vehicle" data-live-search="true">
                        @foreach (\App\Models\Vehicle::DELIVERY_VEHICLE as $value)
                            <option value="{{ $value }}" @if ((isset($vehicles) && $vehicles->vehicle === $value) || old('vehicle') === $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('vehicle')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- <div class="col-md-4 col-sm-6 col-12 id_field"> --}}
                {{-- <div class="form-group"> --}}
                    {{-- <label for="type">type</label> --}}
                    {{-- <input type="text" name="type" id="type" value="@if (isset($vehicles)){{ $vehicles->type }}@else{{ old('type') }}@endif" placeholder="Enter Type" class="form-controal"> --}}
                    {{-- <select name="type" id="type" placeholder="Select Type" data-live-search="true">
                        @foreach (\App\Models\Vehicle::TYPE as $value)
                            <option value="{{ $value }}" @if ((isset($vehicles) && $vehicles->type === $value) || old('type') === $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select> --}}
                    {{-- @error('type')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror --}}
                {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div class="col-md-4 col-sm-6 col-12 delivery_vehicle_field">
                <div class="form-group">
                    <label for="type">type</label>
                    <select name="type" id="type" placeholder="Select Type" data-live-search="true">
                        @foreach (\App\Models\Vehicle::DELIVERY_TYPE as $value)
                            <option value="{{ $value }}" @if ((isset($vehicles) && $vehicles->type === $value) || old('type') === $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div> --}}
            <div class="col-md-4 col-sm-6 col-12 id_field">
                <div class="form-group">
                    <label for="fuel">Fuel <span class="mandatory-field">*</span></label>
                    {{-- <input type="text" name="fuel" id="fuel" value="@if (isset($vehicles)){{ $vehicles->fuel }}@else{{ old('fuel') }}@endif" placeholder="Enter Fuel" class="form-controal"> --}}
                    <select name="fuel" id="fuel" placeholder="Select Fuel" data-live-search="true">
                        @foreach (\App\Models\Vehicle::FUEL as $value)
                            <option value="{{ $value }}" @if ((isset($vehicles) && $vehicles->fuel === $value) || old('fuel') === $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('fuel')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12 delivery_vehicle_field">
                <div class="form-group">
                    <label for="fuel">Fuel <span class="mandatory-field">*</span></label>
                    <select name="fuel" id="fuel" placeholder="Please Select" data-live-search="true">
                        <option value="">Select Fuel</option>
                        @foreach (\App\Models\Vehicle::DELIVERY_FUEL as $value)
                            <option value="{{ $value }}" @if ((isset($vehicles) && $vehicles->fuel === $value) || old('fuel') === $value) selected @endif>
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
                    <label for="factors">Emission Factor <span class="mandatory-field">*</span></label>
                    <input type="text" name="factors" id="factors" placeholder="Enter Emission Factor" class="form-controal" value="@if(isset($vehicles)){{ $vehicles->factors }}@else{{old('factors')}}@endif">
                    @error('factors')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="formula">Formula</label>
                        <input type="text" name="formula" id="formula" value="@if (isset($vehicles)){{ $vehicles->formula }}@else{{ old('formula') }}@endif" placeholder="Enter Formula" class="form-controal">
                        @error('formula')
                        <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{ route('vehicles.index') }}" class="back-btn" title="cancel">Cancel</a>
                    <button type="submit" class="btn-primary" title="submit">Submit</button>
                </div>
            </div>

        </div>

        </form>
    </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript"> 
        $(document).ready(function() {
            // Initial state on page load
            toggleFields();

            $('#vehicle_type').on('change', function() {
                toggleFields();
            });

            function toggleFields() {
                var selectedType = $('#vehicle_type').val();
                if (selectedType == 1) {
                    $('.id_field').show().find('select, input').prop('disabled', false);
                    $('.delivery_vehicle_field').hide().find('select, input').prop('disabled', true);
                } else if (selectedType == 2) {
                    $('.id_field').hide().find('select, input').prop('disabled', true);
                    $('.delivery_vehicle_field').show().find('select, input').prop('disabled', false);
                } else {
                    $('.id_field').hide().find('select, input').prop('disabled', true);
                    $('.delivery_vehicle_field').hide().find('select, input').prop('disabled', true);
                }
            }

        });
    </script>
@endsection
