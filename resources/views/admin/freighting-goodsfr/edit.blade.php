@extends('admin.layouts.app')
@section('title')
Edit Freighting Goods
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('freighting-goodsfr.index') }}">Freighting Goods</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ul>
    <div class="customer-support">
        <form class="input-form" id="bussiness-edit" method="POST"
            action="{{ route('freighting-goodsfr.update', $fgedit->id) }}">
            @csrf
            <div class="row">
                {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Row ID</label>
                        <input type="number" name="row_id" value="{{ $fgedit->row_id ?? old('row_id') }}"
                            placeholder="Row ID" class="form-controal">
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
                                <option value="{{ $value }}" {{ old('vehicle') == $value ? 'selected' : '' }}
                                    {{ optional($fgedit)->vehicle == $value ? 'selected' : '' }}>{{ $value }}</option>
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
                        <input type="text" name="type" id="type" value="{{ old('type', isset($fgedit) ? $fgedit->type : '') }}"
                            placeholder="Type" class="form-controal">
                        @error('type')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="unit" >Unit <span class="mandatory-field">*</span></label>
                        <select placeholder="Select Unit" name="unit" id="unit" data-live-search="true">
                            @foreach (\App\Models\FreightingGoodsFlightsRails::UNIT as $value)
                                <option value="{{ $value }}" {{ old('unit') == $value ? 'selected' : '' }}
                                    {{ optional($fgedit)->unit === $value ? 'selected' : '' }}>
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
                        <label for="factors" >Emission Factor <span class="mandatory-field">*</span></label>
                        <input type="text" name="factors" value="{{ $fgedit->factors ?? old('factors') }}"
                            placeholder="Enter Emission Factor" class="form-controal">
                        @error('factors')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Formula</label>
                        <input type="text" name="formula" value="{{ $fgedit->formula ?? old('formula') }}"
                            placeholder="Formula" class="form-controal">
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
