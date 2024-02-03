@extends('admin.layouts.app')
@section('title')
Create Food Cosumption
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('foodcosumption.index') }}">Food Cosumption Management</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ul>
    <div class="customer-support">
        <form class="input-form" id="welltotankfuels-create" method="POST" action="{{ route('foodcosumption.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label >Row ID</label>
                        <input type="number" name="row_id" value="{{ old('row_id') }}" placeholder="123"
                            class="form-controal">
                        @error('row_id')
                            <span class="error-mgs">
                                <strong> {{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> --}}

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="vehicle">Food <span class="mandatory-field">*</span></label>
                        <input type="text" name="vehicle" id="vehicle" value="{{ old('vehicle') }}" placeholder="Enter Food"
                            class="form-controal">
                        @error('vehicle')
                            <span class="error-mgs">
                                <strong> {{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="type">Type <span class="mandatory-field">*</span></label>
                        <select name="type" id="type" placeholder="Select Type" data-live-search="true">
                            @foreach (\App\Models\FoodCosumption::TYPE as $value)
                            <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
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
                        {{-- <input type="text" name="unit" value="{{ old('unit') }}" placeholder="kg"
                            class="form-controal"> --}}
                        <select name="unit" id="unit" placeholder="Select Unit" data-live-search="true">
                            @foreach (\App\Models\FoodCosumption::UNIT as $value)
                                <option value="{{ $value }}">
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                            @error('unit')
                                <span class="error-mgs">
                                    <strong> {{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="factors">Emission Factor <span class="mandatory-field">*</span></label>
                        <input type="text" name="factors" id="factors" value="{{ old('factors') }}" placeholder="Enter Emission Factor"
                            class="form-controal">
                        @error('factors')
                            <span class="error-mgs">
                                <strong> {{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Formula</label>
                        <input type="text" name="formula" value="{{ old('formula') }}" placeholder="123"
                            class="form-controal">
                        @error('formula')
                            <span class="error-mgs">
                                <strong> {{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> --}}

                <div class="col-12">
                    <div class="towbutton-row">
                        <a href="{{ route('foodcosumption.index') }}" class="back-btn" title="cancel">Cancel</a>
                        <button type="submit" class="btn-primary" title="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer_scripts')
@endsection
