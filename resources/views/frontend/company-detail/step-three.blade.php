@extends('frontend.layouts.app')
@section('title')
    Company Details
@endsection
@section('content')
    <div class="choose-industry">
        <div class="bg-main">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <h2 class="section-title">Choose Industry <span class="mandatory-field">*</span></h2>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="link">
                        <a href="javascript:void(0)">Save as draft</a>
                    </div>
                </div>
            </div>
            <form class="input-form" id="step-three-form" method="post" novalidate=""
                action="{{ route('company-detail-step-three.create') }}">
                @csrf()
                <input type="hidden" name="id" value="{{ $companyData[0]['id'] }}">
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="form-group public-sector">
                            <select class="form-control" name="company_industry_id" id="company_industry_id" title="Select Company Industry">
                                @if (count($companyIndustryData) > 0)
                                    @foreach ($companyIndustryData as $value)
                                    <option value="{{ $value['id'] }}"
                                            {{ $companyData[0]['company_industry_id'] == $value['id'] ? 'selected' : '' }}>
                                            {{ $value['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="emission-scope">
                    <h2 class="title">Activity <span class="mandatory-field">*</span></h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="activity[]" id="activity" class="form-control"  title="Select emission"
                                    multiple>
                                    @if (count($activityData) > 0)
                                        @forelse ($activityData as $value)
                                            <option value="{{ $value['id'] }}"
                                                {{ in_array($value['id'], \Illuminate\Support\Arr::pluck($companyData[0]['companyactivities'], 'activity_id')) ? 'selected' : '' }}>
                                                {{ $value['name'] }}</option>
                                        @empty
                                            <option value="" disabled>No emission types available</option>
                                        @endforelse
                                    @endif
                                </select>
                                {{-- <select class="form-control" multiple title="Scope 1">
                                    <option>Scope 1</option>
                                    <option>Fuels</option>
                                    <option>Refrigerants</option>
                                    <option>Electricity</option>
                                    <option>Water Supply</option>
                                    <option>Material Use</option>
                                    <option>Waste disposal</option>
                                    <option>Business Travel</option>
                                    <option>Food</option>
                                    <option>Home Office</option>
                                </select> --}}
                                <ul class="select-option">
                                    {{-- <li class="option">Fuel <span class="span">&#x2715</span></li>
                                    <li class="option">Electricity <span>&#x2715</span></li>
                                    <li class="option">Water Supply <span>&#x2715</span></li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="savedraft" id="savedraft" value="continue">
                <div class="row">
                    <div class="col-12">
                        <div class="btn-wrap">
                            <div class="button-row previous">
                                <a class="btn-primary" href="{{ route('company-detail-step-two.index') }}" title="PREVIOUS">
                                    <picture>
                                        <img src="{{ asset('assets/images/Arrow-left.svg') }}" alt="button-arrow" width="24"
                                            height="24">
                                    </picture>
                                    PREVIOUS
                                </a>
                            </div>
                            <div class="button-row continue">
                                <button type="submit" class="btn-primary" id="step-three-continue">CONTINUE
                                    <picture>
                                        <img src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow"
                                            width="24" height="24">
                                    </picture>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest(
        \App\Http\Requests\Frontend\CreateCompanyDetailStepThreeRequest::class,
        '#step-three-form',
    ) !!}
    <script type="text/javascript">
        $('.link').click(function() {
            $('#savedraft').val('savedraft');
            $('#step-three-continue').trigger('click');
        });
    </script>
@endsection
