@extends('admin.layouts.app')

@section('title')
Create Business Travels
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('bussinesstravel.index') }}">Businees Travel</a></li>
    <li class="breadcrumb-item active">Create</li>
</ul>
    <div class="customer-support">
      <form class="input-form" id="bussinesstravel-create" method="POST" action="{{ route('bussinesstravel.store') }}"  enctype="multipart/form-data" >
        @csrf
        <div class="row">
            {{-- <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label>Row ID</label>
                    <input type="number" name="row_id" value="{{ old('row_id') }}" placeholder="Row ID" 
                    class="form-controal">
                    @error('row_id')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div> --}}

            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="vehicles">Vehicle <span class="mandatory-field">*</span></label>
            <select name="vehicles" placeholder="Select Vehicle" id="vehicles" data-live-search="true">
                @foreach (\App\Models\BusinessTravels::VEHICLE as $value)
                    <option value="{{ $value }}" {{ old('vehicles') == $value ? 'selected' : '' }}>
                        {{ $value }}</option>
                @endforeach
            </select>
                    @error('vehicles')
                    <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="type">Type <span class="mandatory-field">*</span></label>
                    <select placeholder="Select Type" name="type" id="type" data-live-search="true">
                        @foreach (\App\Models\BusinessTravels::TYPE as $value)
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
                    <select placeholder="Select Fuel" name="fuel" id="fuel" data-live-search="true">
                @foreach (\App\Models\BusinessTravels::FUEL as $value)
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
                    <select placeholder="Select Unit" name="unit" id="unit" data-live-search="true">
                @foreach (\App\Models\BusinessTravels::UNIT as $value)
                <option value="{{ $value }}" {{ old('unit') == $value ? 'selected' : '' }}>
                    {{ $value }}
                </option>
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
                    <input type="text" name="factors" value="{{ old('factors') }}" placeholder="Enter Emission Factor" 
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
                    <label>Formula</label>
                    <input type="text" name="formula" value="{{ old('formula') }}" placeholder="Formula" 
                    class="form-controal">
                    @error('formula')
                    <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div> --}}

            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{route('bussinesstravel.index')}}" class="back-btn">Cancel</a>
                    <button type="submit" title="submit" class="btn-primary" href="">Submit</button>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection
@section('footer_scripts')
@endsection
