@extends('admin.layouts.app')
@section('title')
    Edit Customer
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customer</a></li>
        <li class="breadcrumb-item active">EDIT</li>
    </ul>
    <div class="customer-support">
        <form action="{{ route('customer.update', $companyInfo[0]['id']) }}" enctype="multipart/form-data" method="post"
            class="input-form">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="user_id" value="{{ $companyInfo[0]['user_id'] }}">
            <input type="hidden" name="company_id" value="{{ $companyInfo[0]['id'] }}">
            <div class="row mb-4">
                <div class="col-md-12 col-12">
                    <h2 class="section-title">Customer Details</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="company_organization">NAME</label>
                        <input type="text" name="company_organization" id="company_organization"
                            value="{{ !empty($companyInfo[0]['user']['name']) ? $companyInfo[0]['user']['name'] : old('company_organization') }}"
                            placeholder="Enter name" class="form-controal" readonly>
                        @error('company_organization')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="email">CUSTOMER EMAIL ADDRESS</label>
                        <input type="text" name="email" id="email"
                            value="{{ !empty($companyInfo[0]['user']['email']) ? $companyInfo[0]['user']['email'] : old('email') }}"
                            placeholder="Enter email address" class="form-controal" readonly>
                        @error('email')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="user_role">User Role</label>
                        <select name="user_role" id="user_role">
                            <option value="">Select Role</option>
                            @foreach ($userRoles as $role)
                                <option value="{{ $role['id'] }}"
                                    {{ $role['role'] == 'Company Admin' ? 'selected' : 'disabled' }}>{{ $role['role'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="subscription_start_date">Subscription Start Date</label>
                        @php
                            if (!empty($companyInfo[0]['usersubscription']['start_date'])) {
                                $startDate = date('Y-m-d', strtotime($companyInfo[0]['usersubscription']['start_date']));
                            } else {
                                $startDate = '';
                            }
                        @endphp
                        <input type="text" name="subscription_start_date" id="subscription_start_date"
                            value="{{ !empty($startDate) ? $startDate : old('subscription_start_date') }}" readonly
                            placeholder="Select subscription start date" class="form-controal datepicker">

                        @error('subscription_start_date')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="subscription_end_date">Subscription End Date</label>
                        @php
                            if (!empty($companyInfo[0]['usersubscription']['end_date'])) {
                                $endDate = date('Y-m-d', strtotime($companyInfo[0]['usersubscription']['end_date']));
                            } else {
                                $endDate = '';
                            }
                        @endphp
                        <input type="text" name="subscription_end_date" id="subscription_end_date"
                            value="{{ !empty($endDate) ? $endDate : old('subscription_end_date') }}" readonly
                            placeholder="Select subscription end date" class="form-controal datepicker">
                        @error('subscription_end_date')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="row mb-4">
                <div class="col-md-12 col-12">
                    <h2 class="section-title">Company Details</h2>
                </div>
            </div>
            <div class="row bottom">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="company_name">COMPANY NAME<span class="mandatory-field">*</span></label>
                        <input type="text" name="company_name" id="company_name"
                            value="{{ !empty($companyInfo[0]['company_name']) ? $companyInfo[0]['company_name'] : old('company_name') }}"
                            placeholder="Enter company name" class="form-controal" minlength="3">
                        @error('company_name')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="company_email">COMPANY EMAIL</label>
                        <input type="text" name="company_email" id="company_email"
                            value="{{ !empty($companyInfo[0]['company_email']) ? $companyInfo[0]['company_email'] : old('company_email') }}"
                            placeholder="Enter company email" class="form-controal">
                        @error('company_email')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="company_phone_number">COMPANY CONTACT NUMBER</label>
                        <input type="text" name="company_phone_number" maxlength="14" id="company_phone_number"
                            value="{{ !empty($companyInfo[0]['company_phone']) ? $companyInfo[0]['company_phone'] : old('company_phone_number') }}"
                            placeholder="Enter contact number" class="form-controal">
                        @error('company_phone_number')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-8 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="logo_name">COMPANY LOGO</label>
                        <div class="input-group">
                            @php
                                $logoUrl = $companyInfo[0]['company_logo'];
                                $explodeurl = explode('/company_admin/', $logoUrl);
                                if (!empty($explodeurl[1])) {
                                    $logoName = $explodeurl[1];
                                } else {
                                    $logoName = '';
                                }

                            @endphp
                            <input type="text" id="logo_name" name="logo_name" class="form-controal"
                                placeholder="Supports: jpg, png" aria-label="Recipient's username"
                                aria-describedby="basic-addon2" value="{{ $logoName }}" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    <div class="in-file">
                                        <input type="file" id="company_logo" name="company_logo" accept="image/*" />
                                        <input type="hidden" id="hidden_company_logo" name="hidden_company_logo"
                                            value="{{ $logoName }}" />
                                        <label for="company_logo">+ ADD FILE</label>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <span class="error-note">Accepted File Types: jpeg, png, jpg, webp file.</span>
                        @error('company_logo')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label>DISPLAY ATTACHMENTS</label>
                        <ul class="attachment company-logo-attachment">
                            <li>
                                @if (!empty($logoName))
                                    <picture>
                                        <img class="imagepop" src="{{ $companyInfo[0]['company_logo'] }}"
                                            alt="file icon" title="file icon">
                                    </picture>
                                @else
                                    <picture>
                                        <img src="{{ asset('assets/images/file-img.png') }}" alt="file icon" title="file">
                                    </picture>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="trade_licence_number">TRADE LICENSE NUMBER</label>
                        <input type="text" name="trade_licence_number" id="trade_licence_number"
                            value="{{ !empty($companyInfo[0]['trade_licence_number']) ? $companyInfo[0]['trade_licence_number'] : old('trade_licence_number') }}"
                            placeholder="Enter licence number" class="form-controal">
                        @error('trade_licence_number')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="no_of_employees">NO. OF EMPLOYEES</label>
                        <select name="no_of_employees" id="no_of_employees">
                            <option value="">Select No Of Employee</option>
                            @foreach (\App\Models\User::NO_OF_EMPLOYEE as $value)
                                <option value="{{ $value }}"
                                    {{ $companyInfo[0]['no_of_employees'] === $value ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                        @error('no_of_employees')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12  col-12">
                    <h2 class="section-title">Company Address</h2>
                </div>
            </div>
            <div class="row bottom">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="country_id">COUNTRY</label>
                        <select name="country_id" id="country_id" data-live-search="true">
                            <option value="">Select Country</option>
                            @php $selected = ""; @endphp
                            @foreach ($countryData as $value)
                                @if (!empty($companyInfo[0]['companyaddresses']) && !empty($companyInfo[0]['companyaddresses'][0]))
                                    @if (
                                        !empty($companyInfo[0]['companyaddresses'][0]['countries']['id']) &&
                                            $companyInfo[0]['companyaddresses'][0]['countries']['id'] == $value['id']
                                    )
                                        @php $selected = "selected"; @endphp
                                    @else
                                        {{-- @if ($value['name'] == 'United Arab Emirates')
                                            @php $selected = "selected"; @endphp
                                        @else --}}
                                        @php $selected = ""; @endphp
                                        {{-- @endif --}}
                                    @endif
                                @else
                                    @php $selected = ""; @endphp
                                    {{-- @if ($value['name'] == 'United Arab Emirates')
                                        @php $selected = "selected"; @endphp
                                    @else
                                        @php $selected = ""; @endphp
                                    @endif --}}
                                @endif

                                <option value="{{ $value['id'] }}" {{ $selected }}>
                                    {{ $value['name'] }}</option>
                            @endforeach
                            {{-- @foreach ($countryData as $value)
                                @if (!empty($companyInfo[0]['companyaddresses']) && !empty($companyInfo[0]['companyaddresses'][0]))
                                    @if (!empty($companyInfo[0]['companyaddresses'][0]['countries']['id']) && $companyInfo[0]['companyaddresses'][0]['countries']['id'] == $value['id'])
                                        @php $selected = "selected"; @endphp
                                    @else
                                        @php $selected = ""; @endphp
                                    @endif
                                @endif 
                                <option value="{{ $value['id'] }}" {{$selected}}>{{ $value['name'] }}</option>
                            @endforeach --}}
                        </select>
                        @error('country_id')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="country">COUNTRY</label>
                        <input type="text" name="country" id="country" value="{{ !empty($companyInfo[0]['companyaddresses'][0]['country']) ? $companyInfo[0]['companyaddresses'][0]['country']: old('country') }}" placeholder="Enter country" class="form-controal">
                        @error('country')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="city">CITY</label>
                        <input type="text" name="city" id="city"
                            value="{{ !empty($companyInfo[0]['companyaddresses'][0]['city']) ? $companyInfo[0]['companyaddresses'][0]['city'] : old('city') }}"
                            placeholder="Enter city" class="form-controal" minlength="3">
                        @error('city')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="address">ADDRESS</label>
                        <textarea name="address" id="address"
                            value="{{ !empty($companyInfo[0]['companyaddresses'][0]['address']) ? $companyInfo[0]['companyaddresses'][0]['address'] : old('address') }}"
                            placeholder="Enter address" class="form-controal" rows="4" maxlength="255">{{ !empty($companyInfo[0]['companyaddresses'][0]['address']) ? $companyInfo[0]['companyaddresses'][0]['address'] : old('address') }}</textarea>
                        @error('address')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12 col-12">
                    <h2 class="section-title">Company Documents</h2>
                </div>
            </div>
            <div class="row bottom">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="trade_license_text">TRADE LICENSE</label>
                        <div class="input-group">
                            <input type="text" id="trade_license_text" name="trade_license_text"
                                class="form-controal" placeholder="Select TRADE LICENSE"
                                aria-label="Recipient's username" aria-describedby="basic-addon2" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    <div class="in-file">
                                        <input type="file" id="tradeLicense" name="tradeLicense[]" multiple
                                            onchange="tradeLicenseNameSet(this)" />
                                        <label for="tradeLicense">+ ADD FILE</label>
                                    </div>
                                </span>
                            </div>
                        </div>
                        @error('tradeLicense.*')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="established_text">ESTABLISHMENT CARD</label>
                        <div class="input-group">
                            <input type="text" id="established_text" name="established_text" class="form-controal"
                                placeholder="Select ESTABLISHMENT CARD" aria-label="Recipient's username"
                                aria-describedby="basic-addon2" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    <div class="in-file">
                                        <input type="file" id="established" name="established[]" multiple
                                            onchange="establishmentNameSet(this);" />
                                        <label for="established">+ ADD FILE</label>
                                    </div>
                                </span>
                            </div>
                        </div>
                        @error('established.*')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label>DISPLAY TRADE LICENSE ATTACHMENTS</label>
                        <ul class="attachment tarde-license-attachment">
                            @if (count($companuDocuments) > 0)
                                @foreach ($companuDocuments as $value)
                                    @if ($value['document_type'] == \App\Models\CompanyDocument::TRADE_LICENSE && $value['file_name'])
                                        @php
                                            $fileExtension = pathinfo($value['file_name'], PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($fileExtension == 'pdf')
                                            <li>
                                                <a href="{{ $value['file_name'] }}" target="_blank">
                                                    <img src="{{ $fileExtension === 'pdf' ? asset('assets/images/pdf.png') : $value['file_name'] }}"
                                                        style="max-width:50px !important; max-height:50px !important;" alt="pdf-icon" title="pdf">
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <picture>
                                                    <img src="{{ !empty($value['file_name']) ? $value['file_name'] : asset('assets/images/pdf.png') }}"
                                                        alt="file icon" title="file">
                                                </picture>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                <li>
                                    <picture>
                                        <img src="{{ asset('assets/images/file-img.png') }}" alt="file icon" title="file">
                                    </picture>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label>DISPLAY ESTABLISHMENT CARD ATTACHMENT</label>
                        <ul class="attachment established-attachment">
                            @if (count($companuDocuments) > 0)
                                @foreach ($companuDocuments as $value)
                                    @if ($value['document_type'] == \App\Models\CompanyDocument::ESTABLISHMENT && $value['file_name'])
                                        @php
                                            $fileExtension = pathinfo($value['file_name'], PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($fileExtension == 'pdf')
                                            <li>
                                                <a href="{{ $value['file_name'] }}" target="_blank">
                                                    <img src="{{ $fileExtension === 'pdf' ? asset('assets/images/pdf.png') : $value['file_name'] }}"
                                                        style="max-width:50px !important; max-height:50px !important;" alt="pdf-icon" title="pdf">
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <picture>
                                                    <img src="{{ !empty($value['file_name']) ? $value['file_name'] : asset('assets/images/pdf.png') }}"
                                                        alt="file icon" title="file">
                                                </picture>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                <li>
                                    <picture>
                                        <img src="{{ asset('assets/images/file-img.png') }}" alt="file icon" title="file">
                                    </picture>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>


            <div class="row mb-4">
                <div class="col-md-12 col-12">
                    <h2 class="section-title">Company Industry & Activities</h2>
                </div>
            </div>
            <div class="row bottom">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="industry">INDUSTRY</label>
                        <select name="industry" id="industry" placeholder="Select Industry"
                            value="{{ old('industry') }}" data-live-search="true">
                            @foreach ($companyIndustry as $industry)
                                <option value="{{ $industry['id'] }}"
                                    {{ $companyInfo[0]['company_industry_id'] == $industry['id'] ? 'selected' : '' }}>
                                    {{ $industry['name'] }}</option>
                            @endforeach
                        </select>
                        @error('industry')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="emissionscope">Activities</label>
                        <select name="emissionscope[]" placeholder="Select Factor" id="emissionscope" multiple
                            data-live-search="true" class="multi-select">
                            @foreach ($scopeData as $value)
                                @php
                                    $selected = '';
                                    if (in_array($value['id'], $scopeArray)) {
                                        $selected = 'selected';
                                    } else {
                                        $selected = '';
                                    }
                                @endphp
                                <option value="{{ $value['id'] }}" {{ $selected }}>{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                        @error('scope1')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="towbutton-row">
                        <a href="{{ route('customer.index') }}" class="back-btn" title="cancel">Cancel</a>
                        <button type="submit" title="submit" class="btn-primary" href="">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer_scripts')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.timepicker.min.css') }}">
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.timepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('assets/js/contact-number-validation.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('assets/js/char-length-validation.js') }}"></script>
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                const file = input.files[0];
                const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];
                const maxFileSize = 15 * 1024 * 1024; // 15MB in bytes
                const fileSize = file.size;
                const fileurl = "{{ asset('assets/images/file-img.png') }}";
                if (fileSize > maxFileSize) {
                    $("#logo_name").val("");
                    $('.company-logo-attachment img').attr('src', fileurl);
                    setReturnMsg("danger", 'File size exceeds 15MB. Please choose a smaller file.');
                    return;
                }
                const fileType = input.files[0].type;
                if (!allowedTypes.includes(fileType)) {
                    setReturnMsg("danger", 'Only upload jpeg, jpg, png, webp files.');
                    return;
                }
                reader.onload = function(e) {
                    var fileName = input.files[0].name;
                    $("#logo_name").val(fileName);
                    $('.company-logo-attachment img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#company_logo").change(function() {
            readURL(this);
        });

        function tradeLicenseNameSet(input) {
            const allowedTypes = new Set(['application/pdf', 'image/png',
                'image/jpeg','image/jpg','application/msword', // DOC
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // DOCX
            ]); // Use a Set for faster lookups
            const allowedSizeInKB = 15360; // 15MB in kilobytes
            const files = input.files;

            if ([...files].some(file => !allowedTypes.has(file.type))) {
                setReturnMsg("danger", "Invalid file type. Only PDF,DOC,DOCX PNG, WEBP,JPEG and JPG files are allowed.");
                // $('#loader').css('display', 'none');
                return;
            }
            const exceedsSizeLimit = [...files].some(file => (file.size / 1024) > allowedSizeInKB);

            if (exceedsSizeLimit) {
                setReturnMsg("danger", "Please upload files less than 15 MB.");
                // $('#loader').css('display', 'none');
                return;
            }

            var total_file = document.getElementById("tradeLicense").files.length;
            $('.tarde-license-attachment li').remove();
            const fileurl = "{{ asset('assets/images/file-img.png') }}";
            for (var i = 0; i < total_file; i++) {
                if (input.files[i].size > 15 * 1024 * 1024) {
                    $('.tarde-license-attachment li').remove();
                    $('.tarde-license-attachment').append('<li><picture><img src="' + fileurl + '"></picture></li>');
                    setReturnMsg("danger", 'Please upload a file with a maximum size of 5MB.');
                    break;
                }
                if (input.files[i].type === 'application/pdf' ||  input.files[i].type === 'application/msword' || input.files[i].type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    var assetURL = (input.files[i].type === 'application/pdf')  ? "{{ asset('assets/images/pdf.png') }}" :  "{{ asset('assets/images/doc.png') }}";
                    $('.tarde-license-attachment').append(
                        '<li><picture><img src="'+assetURL+'" style="max-width:50px !important;max-height:50px !important;"></picture></li>'
                        );
                } else if (input.files[i].type === 'image/png' || input.files[i].type === 'image/jpg' || input.files[i]
                    .type === 'image/webp' || input.files[i].type === 'image/jpeg') {
                    $('.tarde-license-attachment').append('<li><picture><img alt="jpg-icon" title="jpg" src="' + URL.createObjectURL(event.target
                            .files[i]) +
                        '" style="max-width:50px !important;max-height:50px !important;"></picture></li>');
                } else {
                    $('.tarde-license-attachment').append(
                        '<li><picture><img src="{{ asset('assets/images/file-img.png') }}" alt="tarde-license-icon" title="tarde-license"></picture></li>');
                }
            }
        }

        function establishmentNameSet(input) {
            const allowedTypes = new Set(['application/pdf', 'image/png',
                'image/jpeg','image/jpg','application/msword', // DOC
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // DOCX
            ]); // Use a Set for faster lookups
            const allowedSizeInKB = 15360; // 15MB in kilobytes
            const files = input.files;

            if ([...files].some(file => !allowedTypes.has(file.type))) {
                setReturnMsg("danger", "Invalid file type. Only PDF,DOC,DOCX PNG, WEBP,JPEG and JPG files are allowed.");
                // $('#loader').css('display', 'none');
                return;
            }
            const exceedsSizeLimit = [...files].some(file => (file.size / 1024) > allowedSizeInKB);

            if (exceedsSizeLimit) {
                setReturnMsg("danger", "Please upload files less than 15 MB.");
                // $('#loader').css('display', 'none');
                return;
            }

            var total_file = document.getElementById("established").files.length;
            $('.established-attachment li').remove();
            const fileurl = "{{ asset('assets/images/file-img.png') }}";
            for (var i = 0; i < total_file; i++) {
                if (input.files[i].size > 15 * 1024 * 1024) {
                    $('.established-attachment li').remove();
                    $('.established-attachment').append('<li><picture><img alt="established-attachment-icon" title="established-attachment"  src="' + fileurl + '"></picture></li>');
                    setReturnMsg("danger", 'Please upload a file with a maximum size of 15MB.');
                    break;
                }
                if (input.files[i].type === 'application/pdf' ||  input.files[i].type === 'application/msword' || input.files[i].type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    var assetURL = (input.files[i].type === 'application/pdf')  ? "{{ asset('assets/images/pdf.png') }}" :  "{{ asset('assets/images/doc.png') }}";
                    $('.established-attachment').append(
                        '<li><picture><img src="'+assetURL+'" alt="established-attachment-icon" title="established-attachment" style="max-width:50px !important;max-height:50px !important;"></picture></li>'
                        );
                } else if (input.files[i].type === 'image/png' || input.files[i].type === 'image/jpg' || input.files[i]
                    .type === 'image/webp' || input.files[i].type === 'image/jpeg') {
                    $('.established-attachment').append('<li><picture><img alt="established-attachment-icon" title="established-attachment" src="' + URL.createObjectURL(event.target.files[
                        i]) + '" style="max-width:50px !important;max-height:50px !important;"></picture></li>');
                } else {
                    $('.established-attachment').append('<li><picture><img alt="established-attachment-icon" title="established-attachment" src="' + fileurl + '"></picture></li>');
                }

            }
        }

        /*****************Date Picker*********************************/
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd', // Adjust the date format as needed
            minDate: new Date(),
            onSelect: function(dateText, inst) {
                var selectedDate = $(this).datepicker('getDate');
                var formattedDateTime = moment(selectedDate).format('YYYY-MM-DD');
                $(this).val(formattedDateTime);
            }
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
@endsection
