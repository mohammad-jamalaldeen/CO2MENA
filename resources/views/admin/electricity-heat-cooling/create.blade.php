@extends('admin.layouts.app')
@section('title')
    @if (isset($electricity_heat_cooling))
        Edit
    @else
        Create
    @endif
    Electricity Heat Cooling
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('electricity-heat-cooling.index') }}">Electricity Heat Cooling Management</a></li>
        @if (isset($electricity_heat_cooling))
            <li class="breadcrumb-item active">Edit</li>
        @else
            <li class="breadcrumb-item active">Create</li>
        @endif
    </ul>
    <div class="customer-support">
        @if (isset($electricity_heat_cooling))
            <form action="{{ route('electricity-heat-cooling.update', $electricity_heat_cooling->id) }}"
                enctype="multipart/form-data" method="post" class="input-form">
                @csrf
            @else
                <form action="{{ route('electricity-heat-cooling.store') }}" enctype="multipart/form-data" method="post"
                    class="input-form">
                    @csrf
        @endif
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    @php
                        $selectedType = old('electricity_type', isset($electricity_heat_cooling) ? $electricity_heat_cooling->electricity_type : null);
                    @endphp
                    <label for="electricity_type">Electricity Type <span class="mandatory-field">*</span></label>
                    {{-- <select name="electricity_type" id="electricity_type" class="form-control" data-live-search="true">
                        <option value="1" {{ $selectedType == 1 ? 'selected' : '' }}>
                            Electricity Grid
                        </option>
                        <option value="2" {{ $selectedType == 2 ? 'selected' : '' }}>
                            Heat And Steam
                        </option>
                        <option value="3" {{ $selectedType == 3 ? 'selected' : '' }}>
                            District Cooling
                        </option>
                    </select> --}}
                    <select class="form-control" name="electricity_type" id="electricity_type">
                        @foreach (\App\Models\Electricity::TYPE as $key => $value)
                            <option value="{{ $key }}" {{ (isset($electricity_heat_cooling) && $electricity_heat_cooling->electricity_type == $key) || old('electricity_type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="activity">Activity <span class="mandatory-field">*</span></label>
                    <input type="text" name="activity" id="activity"
                        value="@if (isset($electricity_heat_cooling)) {{ $electricity_heat_cooling->activity }}@else{{ old('activity') }}@endif"
                        placeholder="Enter Activity" class="form-controal">
                    @error('activity')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12 field_country">
                <div class="form-group">
                    <label for="select">Country <span class="mandatory-field">*</span></label>
                    {{-- <input type="text" name="country" id="country"
                        value="@if (isset($electricity_heat_cooling)) {{ $electricity_heat_cooling->country }}@else{{ old('country') }} @endif"
                        placeholder="Enter Country" class="form-controal"> --}}
                    <select name="country" id="select" placeholder="Select Country" data-live-search="true">
                        @foreach ($country as $value)
                            <option value="{{ $value->id }}"
                                {{ (isset($electricity_heat_cooling) && $electricity_heat_cooling->country == $value->id) || old('country') == $value->id ? 'selected' : '' }}>
                                {{ $value->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12 field_type">
                <div class="form-group">
                    <label for="type">Type</label>
                    <input type="text" name="type" id="type"
                        value="@if (isset($electricity_heat_cooling)) {{ $electricity_heat_cooling->type }}@else{{ old('type') }}@endif"
                        placeholder="Enter Type" class="form-controal">
                    @error('type')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="unit">Unit <span class="mandatory-field">*</span></label>
                    {{-- <input type="text" name="unit" id="unit"
                        value="@if (isset($electricity_heat_cooling)) {{ $electricity_heat_cooling->unit }}@else{{ old('unit') }} @endif"
                        placeholder="Enter Unit" class="form-controal"> --}}
                    <select name="unit" id="unit" placeholder="Please Unit" data-live-search="true">
                        @foreach (\App\Models\Electricity::UNIT as $value)
                            <option value="{{ $value }}"
                                @if (isset($electricity_heat_cooling) && $electricity_heat_cooling->unit === $value) selected @elseif(old('unit') == $value) selected @endif>
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
                            value="@if(isset($electricity_heat_cooling)){{ $electricity_heat_cooling->factors }}@else{{ old('factors') }}@endif"
                            placeholder="Enter Emission Factor">
                        @error('factors')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{ route('electricity-heat-cooling.index') }}" class="back-btn" title="cancel">Cancel</a>
                    <button type="submit" title="submit" class="btn-primary" href="">Submit</button>
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

            $('#electricity_type').on('change', function() {
                toggleFields();
            });

            function toggleFields() {
                var selectedType = $('#electricity_type').val();
                var modelElectricityType = @json($electricity_heat_cooling->electricity_type ?? null);
                var selectedTypeValue = selectedType || modelElectricityType;

                if (selectedTypeValue == 2) {
                    $(".field_type").show();
                    $(".field_country").hide();
                } else {
                    $(".field_type").hide();
                    $(".field_country").show();
                }
            }
        });
    </script>
@endsection
