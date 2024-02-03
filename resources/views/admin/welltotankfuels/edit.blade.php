@extends('admin.layouts.app')
@section('title')
Edit Well To Tank Fuels
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('welltotankfuels.index') }}">Well To Tank Fuels Management</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ul>
    <div class="customer-support">
        <form class="input-form" id="wttfules-create" method="POST"
            action="{{ route('welltotankfuels.update', $wttfules->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Row ID</label>
                        <input type="number" name="row_id" value="{{ $wttfules->row_id ?? old('row_id') }}" placeholder="123"
                            class="form-controal">
                        @error('row_id')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="type">Type <span class="mandatory-field">*</span></label>
                        {{-- <input type="text" name="type" value="{{ $wttfules->type ?? old('type') }}" placeholder="Gaseous fuels" 
                        class="form-controal"> --}}
                        <select name="type" id="type" placeholder="Select Type" data-live-search="true">
                            @foreach (\App\Models\WttFules::TYPE as $value)
                            <option value="{{ $value }}" @if (isset($wttfules) && $wttfules->type === $value) selected @endif>
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
                        <label for="fuel">Fuel <span class="mandatory-field">*</span></label>
                        <input type="text" name="fuel" value="{{ $wttfules->fuel ?? old('fuel') }}" placeholder="Natural gas" 
                        class="form-controal">
                        @error('fuel')
                        <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="unit">Unit <span class="mandatory-field">*</span></label>
                        {{-- <input type="text" name="unit" value="{{ $wttfules->unit ?? old('unit') }}" placeholder="kg" 
                        class="form-controal"> --}}
                        <select name="unit" id="unit" placeholder="Select Unit" data-live-search="true">
                            @foreach (\App\Models\WttFules::UNIT as $value)
                            <option value="{{ $value }}" @if (isset($wttfules) && $wttfules->unit === $value) selected @endif>
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
                        <input type="text" name="factors" value="{{ $wttfules->factors ?? old('factors') }}" placeholder="123" 
                        class="form-controal">
                        @error('factors')
                        <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Formula</label>
                        <input type="text" name="formula" value="{{ $wttfules->formula ?? old('formula') }}" placeholder="123" 
                        class="form-controal">
                        @error('formula')
                        <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}

                <div class="col-12">
                    <div class="towbutton-row">
                        <a href="{{ route('welltotankfuels.index') }}" class="back-btn" title="cancel">Cancel</a>
                        <button type="submit" class="btn-primary" title="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer_scripts')
@endsection
