@extends('frontend.layouts.app')
@section('title')
    Company Details
@endsection
@section('content')
    <section class="company-details">
        <div class="container-fluid">
            <div class="bg-main">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2 class="section-title">Company Details</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="link">
                            <a href="javascript:void(0)" title="Save as draft">Save as draft</a>
                        </div>
                    </div>
                </div>
                <form class="input-form" method="post" id="step-one-form" novalidate=""
                    action="{{ route('company-detail-step-one.create') }}" enctype="multipart/form-data">
                    @csrf()
                    @if ($companyData != null)
                        <input type="hidden" class="form-control" name="id" id="id"
                            value="{{ optional($companyData)->id ?? '' }}">
                    @endif
                    <div class="row">
                        <div class="col-xl-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="company_name">NAME OF ORGANIZATION <span class="mandatory-field">*</span></label>
                                <input type="text" class="form-control" name="company_name" minlength="5"
                                    id="company_name" value="{{ optional($companyData)->company_name ?? '' }}"
                                    placeholder="Organization name" maxlength="255">
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="trade_licence_number">TRADE LICENSE NUMBER <span class="mandatory-field">*</span></label>
                                <input type="text" class="form-control" name="trade_licence_number"
                                    id="trade_licence_number" minlength="10"
                                    value="{{ optional($companyData)->trade_licence_number ?? '' }}"
                                    placeholder="Enter Trade License Number">
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 col-12">
                            <div class="form-group number-of-employee">
                                <label for="no_of_employees">NUMBER OF EMPLOYEES <span class="mandatory-field">*</span></label>
                                <select name="no_of_employees" id="no_of_employees" title="Select Employees">
                                    @foreach (\App\Models\User::NO_OF_EMPLOYEE as $value)
                                        <option value="{{ $value }}"
                                            {{ optional($companyData)->no_of_employees === $value ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="company_email">EMAIL ADDRESS <span class="mandatory-field">*</span></label>
                                <input type="email" class="form-control" name="company_email" id="company_email"
                                    value="{{ optional($companyData)->company_email ?? '' }}"
                                    placeholder="Enter email address">
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="company_phone">CONTACT NUMBER <span class="mandatory-field">*</span></label>
                                <input type="text" class="form-control" name="company_phone" id="company_phone"
                                    value="{{ optional($companyData)->company_phone ?? '' }}"
                                    placeholder="Enter Contact Number" maxlength="15" >
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 col-12">
                            <div class="form-group add-company-logo">
                                <label for="company_logo">COMPANY LOGO</label>
                                <div class="row">
                                    <div class="col-12 ">
                                        <span class="upload-btn"
                                            id="upload-btn">{{ !optional($companyData)->file_name || !str_contains(optional($companyData)->company_logo, 'No_image_available.png') ? optional($companyData)->file_name ?? 'Select Company Logo' : 'Select Company Logo' }}</span>
                                        <input type="file" id="company_logo" class="file-border" name="company_logo"
                                            accept="image/*" onchange="logoNameSet(this)">
                                            <span class="error-note">Accepted File Types: jpeg, png, jpg, webp file.</span>
                                        <img src="{{ optional($companyData)->company_logo }}" height="20" width="20"
                                            id="company-logo-preview" class="imagepop" alt="no image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row bottom">
                        <h2 class="section-title">Company Address</h2>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="address">ADDRESS </label>
                                <input type="text" name="address" id="address" class="form-control"
                                    value="@if ($companyData && $companyData->companyaddresses && $companyData->companyaddresses->first()) {{ $companyData->companyaddresses->first()->address }} @endif"
                                    placeholder="Enter address">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group number-of-employee">
                                <label for="country_id">COUNTRY</label>
                                <select name="country_id" id="country_id" class="show-menu-arrow" title="Select Country"
                                    data-live-search="true">
                                    @foreach ($countryData as $value)
                                        <option value="{{ $value['id'] }}"
                                            @if ($companyData && isset($companyData->companyaddresses) && optional($companyData->companyaddresses)->first()) {{ $companyData->companyaddresses->first()->country_id == $value['id'] ? 'selected' : '' }}@else{{ $value['name'] == 'United Arab Emirates' ? 'selected' : '' }} @endif>
                                            {{ $value['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="city">CITY</label>
                                <input type="text" name="city" id="city" class="form-control" minlength="3"
                                    value="@if($companyData && $companyData->companyaddresses && $companyData->companyaddresses->first()){{ $companyData->companyaddresses->first()->city }}@endif"
                                    placeholder="Enter city name">
                            </div>
                        </div>
                        <input type="hidden" name="savedraft" id="savedraft" value="continue">
                    </div>
                    <div class="button-row continue">
                        <button type="submit" class="btn-primary" id="step-one-continue"
                            data-bs-toggle="modal" title="continue">CONTINUE
                            <picture>
                                <img src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow"
                                    width="24" height="24">
                            </picture>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @include('common-modal.image-preview-modal')
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest(
        \App\Http\Requests\Frontend\CreateCompanyDetailStepOneRequest::class,
        '#step-one-form',
    ) !!}
    <script type="text/javascript">
        function logoNameSet(input) {
            const file = input.files[0];
            const fileType = file?.type;
            const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];
            const maxFileSize = 15 * 1024 * 1024; // 15MB in bytes
            const fileSize = file.size;

            if (fileSize > maxFileSize) {
                // setReturnMsg("danger", 'File size exceeds 15MB. Please choose a smaller file.');
                return;
            }


            if (fileType && allowedTypes.includes(fileType) && file.size <= maxFileSize) {
                const reader = new FileReader();
                reader.onload = (event) => $('#company-logo-preview').attr('src', event.target.result);
                $('#upload-btn').text(input.files[0].name);
                reader.readAsDataURL(input.files[0]);
                $('#image-logo-ancher').attr('href', '#').removeAttr('target');
            }
        }

        $('.link').click(function() {
            $('#savedraft').val('savedraft');
            $('#step-one-continue').trigger('click');
        });

        function setReturnMsg(title, message) {
            var title = title;
            var lowercaseString = title.toLowerCase();
            if (lowercaseString == "danger") {
                title = 'Error';
            }
            $.notify({
                title: '<strong>' + title + '</strong>',
                message: "<br>" + message + "",
            }, {
                element: 'body',
                position: null,
                type: lowercaseString,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 999999,
                delay: 2000,
                timer: 1000,
                mouse_over: null,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutRight'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
            });
        }
    </script>
    {{-- <script type="text/javascript" src="{{ asset('assets/js/contact-number-validation.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('assets/js/char-length-validation.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/image-preview.js') }}"></script>
@endsection
