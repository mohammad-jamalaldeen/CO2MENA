@extends('admin.layouts.app')
@section('title')
    @if (isset($flight))
        Edit
    @else
        Create
    @endif
    Flight
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('flight.index') }}">Flight Management</a></li>
        @if (isset($flight))
            <li class="breadcrumb-item active">Edit</li>
        @else
            <li class="breadcrumb-item active">Create</li>
        @endif
    </ul>
    <div class="customer-support">
        @if (isset($flight))
            <form action="{{ route('flight.update', $flight->id) }}" enctype="multipart/form-data" method="post"
                class="input-form">
                @csrf
            @else
                <form action="{{ route('flight.store') }}" enctype="multipart/form-data" method="post" class="input-form">
                    @csrf
        @endif
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="origin">Origin (city or IATA code) <span class="mandatory-field">*</span></label>
                    <select name="origin" id="origin" placeholder="Select Origin" data-live-search="true">
                        @foreach ($cities as $value)
                            <option value="{{ $value->id }}"
                                {{ (isset($flight) && $flight->origin == $value->id) || old('origin') == $value->id ? 'selected' : '' }}>
                                {{ $value->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('origin')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="destination">Destination (city or IATA code) <span class="mandatory-field">*</span></label>
                    <select name="destination" id="destination" placeholder="Select Destination" data-live-search="true">
                        @foreach ($cities as $value)
                            <option value="{{ $value->id }}"
                                {{ (isset($flight) && $flight->destination == $value->id) || old('destination') == $value->id ? 'selected' : '' }}>
                                {{ $value->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('destination')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="distance">Distance <span class="mandatory-field">*</span></label>
                    <input type="text" name="distance" id="distance"
                        value="@if (isset($flight)) {{ $flight->distance }}@else{{ old('distance') }}@endif"
                        placeholder="Enter Distance" class="form-controal">
                    @error('distance')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="class">Class <span class="mandatory-field">*</span></label>
                    <select name="class" id="class" placeholder="Select Class" data-live-search="true" class="class_type">
                        @foreach (\App\Models\Flight::CLASS_TYPE as $value)
                            <option value="{{ $value }}"
                                @if (isset($flight) && $flight->class === $value) selected @elseif(old('class') == $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    <select name="class" id="class" placeholder="Select Class" data-live-search="true" class="class_type1">
                        @foreach (\App\Models\Flight::CLASS_TYPE1 as $value)
                            <option value="{{ $value }}"
                                @if (isset($flight) && $flight->class === $value) selected @elseif(old('class') == $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('class')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="single_way_and_return">Single way / return <span class="mandatory-field">*</span></label>
                    <select name="single_way_and_return" placeholder="Select Single way / return" id="single_way_and_return"
                        data-live-search="true">
                        @foreach (\App\Models\Flight::SINGLE_WAY_RETURN as $value)
                            <option value="{{ $value }}"
                                @if (isset($flight) && $flight->single_way_and_return === $value) selected @elseif(old('single_way_and_return') == $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('single_way_and_return')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{ route('flight.index') }}" class="back-btn" title="cancel">Cancel</a>
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
    toggleFields();

    $('#distance').on('input', function(){
        toggleFields();
    });

    function toggleFields() {
        var distance = $('#distance').val();
        if (distance < 3700) {
            $('.class_type').show().find('select, input').prop('disabled', false);
            $('.class_type1').hide().find('select, input').prop('disabled', true);
        } else if (distance > 3700) {
            $('.class_type').hide().find('select, input').prop('disabled', true);
            $('.class_type1').show().find('select, input').prop('disabled', false);
        } else {
            $('.class_type').hide().find('select, input').prop('disabled', true);
            $('.class_type1').hide().find('select, input').prop('disabled', false);
        }
    }
});

</script>
@endsection
