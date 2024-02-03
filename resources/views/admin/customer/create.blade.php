@extends('admin.layouts.app')
@section('title')
Create Customer
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customer</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ul>
    <div class="customer-support">
        <form id="customercreateform" action="{{ route('customer.store') }}" enctype="multipart/form-data" method="post" class="input-form">
            @csrf
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="customer-title">Customer Details</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="company_organization">NAME <span class="mandatory-field">*</span></label>
                        <input type="text" name="company_organization" id="company_organization"
                            value="{{ old('company_organization') }}" minlength="3" placeholder="Enter name" class="form-controal">
                        @error('company_organization')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="email">CUSTOMER EMAIL ADDRESS <span class="mandatory-field">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" minlength="10"
                            placeholder="Enter email address" class="form-controal">
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
                                <option value="{{ $role['id']}}" {{$role['role'] == "Company Admin" ? 'selected':"disabled"}}>{{ $role['role'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group ">
                        <label for="subscription_start_date">Subscription Start Date <span class="mandatory-field">*</span></label>
                        <input type="text" name="subscription_start_date" id="subscription_start_date"
                            value="{{ old('subscription_start_date') }}" readonly placeholder="Select subscription start date"
                            class="form-controal datepicker">

                        @error('subscription_start_date')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="subscription_end_date">Subscription End Date <span class="mandatory-field">*</span></label>
                        <input type="text" name="subscription_end_date" id="subscription_end_date"
                            value="{{ old('subscription_end_date') }}" readonly placeholder="Select subscription end date"
                            class="form-controal datepicker">
                        @error('subscription_end_date')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="customer-title">Company Details</h2>
                </div>
            </div>
            <div class="row bottom">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="company_name">COMPANY NAME<span class="mandatory-field">*</span></label>
                        <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" minlength="3"
                            placeholder="Enter company name" class="form-controal">
                        @error('company_name')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="company_email">COMPANY EMAIL</label>
                        <input type="email" name="company_email" id="company_email" value="{{ old('company_email') }}"
                            placeholder="Enter company email" class="form-controal">
                        @error('company_email')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="company_phone_number">COMPANY CONTACT NUMBER</label>
                        <input type="text" name="company_phone_number"  maxlength="15"
                            id="company_phone_number" value="{{ old('company_phone_number') }}"
                            placeholder="Enter contact number" class="form-controal">
                        @error('company_phone_number')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-8 col-sm-7 col-12">
                    <div class="form-group">
                        <label>COMPANY LOGO</label>
                        <div class="input-group">
                            <input type="text" id="logo_name" name="logo_name" class="form-controal"
                                placeholder="Select company logo" aria-label="Recipient's username"
                                aria-describedby="basic-addon2" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    <div class="in-file">
                                        <input type="file" id="company_logo" name="company_logo" accept="image/*" />
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
                <div class="col-md-4 col-sm-5 col-12">
                    <div class="form-group">
                        <label>DISPLAY ATTACHMENTS</label>
                        <ul class="attachment company-logo-attachment">
                            <li>
                                <picture>
                                    <img src="{{ asset('assets/images/file-img.png') }}" alt="file icon" title="file icon">
                                </picture>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="trade_licence_number">TRADE LICENSE NUMBER</label>
                        <input type="text" name="trade_licence_number" id="trade_licence_number"
                            value="{{ old('trade_licence_number') }}" placeholder="Enter licence number"  class="form-controal">
                        @error('trade_licence_number')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="no_of_employees">NO. OF EMPLOYEES</label>
                        <select name="no_of_employees" id="no_of_employees" placeholder="Select No Of Employee">
                            @foreach (\App\Models\User::NO_OF_EMPLOYEE as $value)
                                <option value="{{ $value }}"
                                    {{ old('no_of_employees') == $value ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('no_of_employees')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12  col-12">
                    <h2 class="customer-title">Company Address</h2>
                </div>
            </div>
            <div class="row bottom">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="country_id">COUNTRY</label>
                        <select name="country_id" id="country_id" data-live-search="true" placeholder="Select Country">
                            @foreach ($countryData as $value)
                                <option value="{{ $value['id'] }}"
                                    {{ old('country_id') == $value['id']? 'selected' : '' }}>
                                    {{-- {{ old('country_id') == $value['id']}}> --}}
                                    {{ $value['name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="city">CITY</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}"
                            placeholder="Enter city" class="form-controal" minlength="3">
                        @error('city')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="address">ADDRESS</label>
                        <textarea name="address" id="address" value="{{ old('address') }}" placeholder="Enter address"
                            class="form-controal" rows="4" maxlength="255">{{ old('address') }}</textarea>
                        @error('address')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="customer-title">Company Documents</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="trade_license_text">TRADE LICENSE</label>
                        <div class="input-group">
                            <input type="text" id="trade_license_text" name="trade_license_text"
                                class="form-controal" placeholder="Select TRADE LICENSE"
                                aria-label="Recipient's username" aria-describedby="basic-addon2" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    <div class="in-file">
                                        <input type="file" id="tradeLicense" name="tradeLicense[]"
                                            multiple onchange="tradeLicenseNameSet(this)" accept=".pdf, .doc, .docx, image/*"/>
                                        <label for="tradeLicense">+ ADD FILE</label>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <span class="error-note">Accepted File Types: jpeg,png,jpg,webp,pdf,doc and docx</span>
                        @error('tradeLicense.*')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="established_text">ESTABLISHMENT CARD</label>
                        <div class="input-group">
                            <input type="text" id="established_text" name="established_text" class="form-controal"
                                placeholder="Select ESTABLISHMENT CARD" aria-label="Recipient's username"
                                aria-describedby="basic-addon2" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    <div class="in-file">
                                        <input type="file" id="established" name="established[]" 
                                            multiple onchange="establishmentNameSet(this);" accept=".pdf, .doc, .docx, image/*" />
                                        <label for="established">+ ADD FILE</label>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <span class="error-note">Accepted File Types: jpeg,png,jpg,webp,pdf,doc and docx</span>

                        @error('established.*')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label class="trade-license-preview"></label>
                        <ul class="attachment tarde-license-attachment">
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label class="established-preview"></label>
                        <ul class="attachment established-attachment">
                        </ul>
                    </div>
                </div>

                {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="no_of_employees">NO. OF EMPLOYEES</label>
                        <select name="no_of_employees" id="no_of_employees" placeholder="Select No Of Employee">
                            @foreach (\App\Models\User::NO_OF_EMPLOYEE as $value)
                                <option value="{{ $value }}"
                                    {{ old('no_of_employees') == $value ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('no_of_employees')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group ">
                        <label for="city">Subscription Start Date</label>
                        <input type="text" name="subscription_start_date" id="subscription_start_date"
                            value="{{ old('subscription_start_date') }}" readonly placeholder="Select subscription start date"
                            class="form-controal datepicker">

                        @error('subscription_start_date')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="city">Subscription End Date</label>
                        <input type="text" name="subscription_end_date" id="subscription_end_date"
                            value="{{ old('subscription_end_date') }}" readonly placeholder="Select subscription end date"
                            class="form-controal datepicker">
                        @error('subscription_end_date')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
                {{-- <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="country_id">COUNTRY</label>
                        <select name="country_id" id="country_id" data-live-search="true" placeholder="Select Country">
                            @foreach ($countryData as $value)
                                <option value="{{ $value['id'] }}"
                                    {{ old('country_id') == $value['id'] || $value['name'] == 'United Arab Emirates' ? 'selected' : '' }}>
                                    {{ $value['name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="city">CITY</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}"
                            placeholder="Enter city" class="form-controal" minlength="3">
                        @error('city')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="customer-title">Company Industry & Activities</h2>
                </div>
            </div>
            <div class="row bottom">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="form-group">
                        <label for="industry">INDUSTRY</label>
                        <select name="industry" id="industry" placeholder="Select Industry"
                            value="{{ old('industry') }}" data-live-search="true">
                            @foreach ($companyIndustry as $industry)
                                <option value="{{ $industry->id }}"
                                    {{ old('industry') == $industry->id ? 'selected' : '' }}>{{ $industry->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('industry')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="form-group">
                        <label for="emissionscope">Activities</label>
                        <select name="emissionscope[]" placeholder="Select Activity" id="emissionscope" multiple class="multi-select"
                            value="{{ old('scope1[]') }}" data-live-search="true">
                            @foreach ($scopes as $scope)
                                <option value="{{ $scope->id }}"
                                    {{ old('emissionscope') == $scope->id ? 'selected' : '' }}>{{ $scope->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('Emissionscope')
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
    
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script type="text/javascript">
        function readURL(input) {
            const file = input.files[0];
            const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];
            const maxFileSize = 15 * 1024 * 1024  ; // 5MB in bytes
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
            if (input.files && input.files[0]) {
                var reader = new FileReader();
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
            $('.tarde-license-attachment li').first().remove();
            $(".trade-license-preview").text("DISPLAY TRADE LICENSE ATTACHMENTS");
            const fileurl = "{{ asset('assets/images/file-img.png') }}";

            for (var i = 0; i < total_file; i++) {
                if (input.files[i].size > 15 * 1024 * 1024) {
                    $('.tarde-license-attachment li').remove();
                    $('.tarde-license-attachment').append('<li><picture><img src="' +fileurl+ '" alt="attachment-icon" title="attachment"></picture></li>');
                    setReturnMsg("danger", 'Please upload a file with a maximum size of 15MB.');
                    break;
                }
                if(input.files[i].type === 'application/pdf' ||  input.files[i].type === 'application/msword' || input.files[i].type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){
                    var assetURL = (input.files[i].type === 'application/pdf')  ? "{{ asset('assets/images/pdf.png') }}" :  "{{ asset('assets/images/doc.png') }}";
                    $('.tarde-license-attachment').append('<li><picture><img src="'+assetURL+'"  alt="pdf-icon" title="pdf" style="max-width:50px !important;max-height:50px !important;"></picture></li>');    
                }else if(input.files[i].type === 'image/png' || input.files[i].type === 'image/jpg' || input.files[i].type === 'image/webp' || input.files[i].type === 'image/jpeg'){
                    $('.tarde-license-attachment').append('<li><picture><img src="'+URL.createObjectURL(event.target.files[i])+'"  alt="jpg-icon" title="JPG" style="max-width:50px !important;max-height:50px !important;"></picture></li>');
                }else{
                    $('.tarde-license-attachment').append('<li><picture><img src="'+fileurl+'" alt="file-icon" title="file"></picture></li>');
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
            $(".established-preview").text("DISPLAY ESTABLISHED ATTACHMENT");
            const fileurl = "{{ asset('assets/images/file-img.png') }}";
            $('.established-attachment li').first().remove();

            for (var i = 0; i < total_file; i++) {
                if (input.files[i].size > 15 * 1024 * 1024) {
                    $('.established-attachment li').remove();
                    $('.established-attachment').append('<li><picture><img src="' +fileurl+ '" alt="image-icon" title="image"></picture></li>');
                    setReturnMsg("danger", 'Please upload a file with a maximum size of 15MB.');
                    break;
                }
                if(input.files[i].type === 'application/pdf' ||  input.files[i].type === 'application/msword' || input.files[i].type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){
                    var assetURL = (input.files[i].type === 'application/pdf')  ? "{{ asset('assets/images/pdf.png') }}" :  "{{ asset('assets/images/doc.png') }}";
                    $('.established-attachment').append('<li><picture><img src="'+assetURL+'" alt="pdf-icon" title="pdf" style="max-width:50px !important;max-height:50px !important;"></picture></li>');    
                }else if(input.files[i].type === 'image/png' || input.files[i].type === 'image/jpg' || input.files[i].type === 'image/webp' || input.files[i].type === 'image/jpeg'){
                    $('.established-attachment').append('<li><picture><img src="'+URL.createObjectURL(event.target.files[i])+'" alt="jpg-icon" title="jpg" style="max-width:50px !important;max-height:50px !important;"></picture></li>');
                }else{
                    $('.established-attachment').append('<li><picture><img src="'+fileurl+'" alt="file-icon" title="file" ></picture></li>');
                }
            }
        }
        /*****************Date Picker*********************************/
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            minDate:  new Date(),
            onSelect: function(dateText, inst) {
                var selectedDate = $(this).datepicker('getDate');
                var formattedDateTime = moment(selectedDate).format('YYYY-MM-DD');
                $(this).val(formattedDateTime);
                $('body').removeClass('no-scroll');
            },
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
@endsection

