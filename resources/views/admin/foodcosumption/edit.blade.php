@extends('admin.layouts.app')
@section('title')
Edit Food Cosumption 
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('foodcosumption.index') }}">Food Cosumption Management</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ul>
    <div class="customer-support">
        <form class="input-form" id="foodcosumption-create" method="POST"
            action="{{ route('foodcosumption.update', $foodcosumption->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Row ID</label>
                        <input type="number" name="row_id" value="{{ $foodcosumption->row_id ?? old('row_id') }}" placeholder="123"
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
                        <input type="text" name="vehicle" id="vehicle" value="{{ $foodcosumption->vehicle ?? old('vehicle') }}" placeholder="Gaseous fuels" 
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
                        <select class="col-md-4 col-12" name="type" id="type" placeholder="Select Type" data-live-search="true">
                            @foreach (\App\Models\FoodCosumption::TYPE as $value)
                                <option value="{{ $value }}"
                                    {{ optional($foodcosumption)->type === $value ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                        @error('type')
                        <span class="error-mgs">
                            <strong> {{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>


                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="unit">Unit <span class="mandatory-field">*</span></label>
                        {{-- <input type="text" name="unit" value="{{ $foodcosumption->unit ?? old('unit') }}" placeholder="kg" 
                        class="form-controal"> --}}
                        <select class="col-md-4 col-12" name="unit" id="unit" placeholder="Select Unit">
                            @foreach (\App\Models\FoodCosumption::UNIT as $value)
                                <option value="{{ $value }}"
                                    {{ optional($foodcosumption)->unit === $value ? 'selected' : '' }}>
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
                        <input type="text" name="factors" value="{{ $foodcosumption->factors ?? old('factors') }}" placeholder="Enter Emission Factor" 
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
                        <input type="text" name="formula" value="{{ $foodcosumption->formula ?? old('formula') }}" placeholder="123" 
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
