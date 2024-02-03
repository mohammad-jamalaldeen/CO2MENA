@extends('admin.layouts.app')

@section('title')
  Create Freighting Good
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('freighting-goodsgvh.index') }}">Freighting Good</a></li>
    <li class="breadcrumb-item active">Create</li>
</ul>
    <div class="customer-support">
        <form class="input-form" id="fg-create" method="POST" action="{{ route('freighting-goodsfr.store') }}"
            enctype="multipart/form-data">
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
                            @foreach (\App\Models\FreightingGoodsFlightsRails::VEHICLE as $value)
                                <option value="{{ $value }}" {{ old('vehicle') === $value ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
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
                        <input type="text" name="type" id="type" placeholder="Type" class="form-controal"
                            value="{{ old('type') }}">
                        @error('type')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="unit">Unit <span class="mandatory-field">*</span></label>
                        <select name="unit" placeholder="Select Unit" id="unit" data-live-search="true">
                            @foreach (\App\Models\FreightingGoodsFlightsRails::UNIT as $value)
                                <option value="{{ $value }}" {{ old('unit') === $value ? 'selected' : '' }}>
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
                        <input type="text" name="factors" id="factors" placeholder="Enter Emission Factor" class="form-controal"
                            value="{{ old('factors') }}">
                        @error('factors')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12" style="display: none;">
                    <div class="form-group">
                        <label for="distance">Distance</label>
                        <input type="text" name="distance" id="distance" placeholder="Distance" class="form-control" value="0">
                        @error('distance')
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
                        <a href="{{ route('freighting-goodsfr.index') }}" class="back-btn" title="cancel">Cancel</a>
                        <button type="submit" class="btn-primary" title="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer_scripts')
@endsection
