@extends('frontend.layouts.main')
@section('title')
    Profile
@endsection
@section('content')
    @if (Auth::guard('web')->user()->user_role_id == 6)
        <section class="profiles-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="profiles-inner-title">Personal Details</h3>
                        <div class="profiles-inner personal-details">
                            <div class="pi-img-wrap">
                                <div class="pi-img">
                                    <div
                                        class="file-wrap {{ frontendPermissionCheck('profile.edit') === false ? 'd-none' : 'd-block' }}">
                                        <div class="in-file">
                                            {{-- <div id="profile-loader" class="loader"></div> --}}
                                            <input type="file" name="profile_picture" id="profile_picture"
                                                onchange="profilePictureChange(this)" accept="image/*"
                                                placeholder="Select Image" title="Select Image" />
                                            <label for="profile_picture">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    viewBox="0 0 12 12">
                                                    <g id="Group_20537" data-name="Group 20537"
                                                        transform="translate(-12916 438)">
                                                        <g id="Group_20537-2" data-name="Group 20537"
                                                            transform="translate(12916 -438)">
                                                            <path id="Path_39675" data-name="Path 39675"
                                                                d="M1.2,13.8l2.52,2.52L0,17.52Z"
                                                                transform="translate(0 -5.52)" fill="#32ae59" />
                                                            <rect id="Rectangle_19281" data-name="Rectangle 19281"
                                                                width="8.28" height="3.6"
                                                                transform="translate(2.043 7.418) rotate(-45)"
                                                                fill="#32ae59" />
                                                            <path id="Path_39676" data-name="Path 39676"
                                                                d="M17.66,2.7l-.54.54L14.6.72l.54-.54a.58.58,0,0,1,.84,0l1.68,1.68A.58.58,0,0,1,17.66,2.7Z"
                                                                transform="translate(-5.84 0)" fill="#32ae59" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                    <picture>
                                        <img src="{{ !empty(optional($companyData->user)->profile_picture) ? optional($companyData->user)->profile_picture : asset('assets/images/No_image_available.png') }}"
                                            id="profile_image" alt="profile image" width="130" height="130"
                                            class="imagepop" />
                                    </picture>
                                </div>
                            </div>
                            <div class="pi-data pi-col1 pd-bg">
                                <ul class="pi-list pd-user-list">
                                    <li class="pi-item">
                                        <strong>USER</strong>
                                        <p>
                                            @if (!empty($companyData->user))
                                                <span>{{ ucwords(optional($companyData->user)->name) ?? '' }}</span>
                                                <span>{{ optional($companyData->user)->email ?? '' }}</span>
                                                <span>{{ optional($companyData->user)->contact_number ?? '' }}</span>
                                            @endif
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="pi-data pd-account pd-bg">
                                <ul class="pi-list pd-account-list">
                                    <li class="pi-item">
                                        <strong>COMPANY ACCOUNT ID</strong>
                                        @if (!empty($companyData->company_account_id))
                                            <span>{{ strtoupper($companyData->company_account_id) ?? '' }}</span>
                                        @endif
                                    </li>
                                    <li class="pi-item">
                                        <strong>REGISTRATION DATE</strong>
                                        @if (!empty($companyData->user))
                                            <span>{{ date('d F, Y', strtotime(optional($companyData->user)->created_at)) }}</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3 class="profiles-inner-title">Company Details</h3>
                        <div class="profiles-inner company-details">
                            <div class="pi-img-wrap cd-bg">
                                <div class="pi-img">
                                    <button
                                        class="edit_btn {{ frontendPermissionCheck('profile.edit') === false ? 'd-none' : 'd-flex' }}"
                                        data-bs-toggle="modal" data-bs-target="#companyDetailsModal" title="profile-edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                            viewBox="0 0 12 12">
                                            <g id="Group_20537" data-name="Group 20537" transform="translate(-12916 438)">
                                                <g id="Group_20537-2" data-name="Group 20537"
                                                    transform="translate(12916 -438)">
                                                    <path id="Path_39675" data-name="Path 39675"
                                                        d="M1.2,13.8l2.52,2.52L0,17.52Z" transform="translate(0 -5.52)"
                                                        fill="#32ae59" />
                                                    <rect id="Rectangle_19281" data-name="Rectangle 19281" width="8.28"
                                                        height="3.6" transform="translate(2.043 7.418) rotate(-45)"
                                                        fill="#32ae59" />
                                                    <path id="Path_39676" data-name="Path 39676"
                                                        d="M17.66,2.7l-.54.54L14.6.72l.54-.54a.58.58,0,0,1,.84,0l1.68,1.68A.58.58,0,0,1,17.66,2.7Z"
                                                        transform="translate(-5.84 0)" fill="#32ae59" />
                                                </g>
                                            </g>
                                        </svg>
                                    </button>
                                    <picture>
                                        <img src="{{ empty($companyData->company_logo) || $companyData->company_logo == '' || $companyData->company_logo == null ? asset('assets/images/company-details-logo.png') : $companyData->company_logo }}"
                                            alt="profile image" width="111" height="37" class="imagepop" />
                                    </picture>
                                </div>
                                <strong>COMPANY LOGO</strong>
                            </div>
                            <div class="pi-data pi-col1 cd-bg">
                                <button
                                    class="edit_btn {{ frontendPermissionCheck('profile.edit') === false ? 'd-none' : 'd-flex' }}"
                                    data-bs-toggle="modal" data-bs-target="#companyDetailsModal" title="profile-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12">
                                        <g id="Group_20537" data-name="Group 20537" transform="translate(-12916 438)">
                                            <g id="Group_20537-2" data-name="Group 20537"
                                                transform="translate(12916 -438)">
                                                <path id="Path_39675" data-name="Path 39675"
                                                    d="M1.2,13.8l2.52,2.52L0,17.52Z" transform="translate(0 -5.52)"
                                                    fill="#32ae59" />
                                                <rect id="Rectangle_19281" data-name="Rectangle 19281" width="8.28"
                                                    height="3.6" transform="translate(2.043 7.418) rotate(-45)"
                                                    fill="#32ae59" />
                                                <path id="Path_39676" data-name="Path 39676"
                                                    d="M17.66,2.7l-.54.54L14.6.72l.54-.54a.58.58,0,0,1,.84,0l1.68,1.68A.58.58,0,0,1,17.66,2.7Z"
                                                    transform="translate(-5.84 0)" fill="#32ae59" />
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                                <ul class="pi-list cd-list">
                                    <li class="pi-item">
                                        @if (!empty($companyData->company_name))
                                            <strong>ORGANIZATION</strong>
                                            <span>{{ optional($companyData)->company_name ?? '' }}</span>
                                        @endif
                                    </li>
                                    <li class="pi-item">
                                        @if (!empty($companyData->trade_licence_number))
                                            <strong>TRADE LICENSE NUMBER</strong>
                                            <span>{{ optional($companyData)->trade_licence_number ?? '' }}</span>
                                        @endif
                                    </li>
                                    <li class="pi-item">
                                        @if (!empty($companyData->no_of_employees))
                                            <strong>NO. OF EMPLOYEES</strong>
                                            <span>{{ optional($companyData)->no_of_employees ?? '' }}</span>
                                        @endif
                                    </li>
                                    <li class="pi-item">
                                        @if (!empty($companyData->company_email))
                                            <strong>EMAIL</strong>
                                            <span>{{ optional($companyData)->company_email ?? '' }}</span>
                                        @endif
                                    </li>
                                    <li class="pi-item">
                                        @if (!empty($companyData->company_phone))
                                            <strong>PHONE</strong>
                                            <span>{{ optional($companyData)->company_phone ?? '' }}</span>
                                        @endif
                                    </li>
                                    <li class="pi-item">
                                        <strong>ADDRESS</strong>
                                        <span id="address-text">
                                            @if ($companyData && $companyData->companyaddresses && $companyData->companyaddresses->first())
                                                {{ !empty($companyData->companyaddresses->first()->address) ? $companyData->companyaddresses->first()->address.',' : '' }}
                                            @endif
                                            @if ($companyData && $companyData->companyaddresses && $companyData->companyaddresses->first())
                                                {{ !empty($companyData->companyaddresses->first()->city) ? $companyData->companyaddresses->first()->city.',' : '' }}
                                            @endif
                                            @if ($companyData && $companyData->companyaddresses && $companyData->companyaddresses->first())
                                                {{ !empty($companyData->companyaddresses->first()->countries->name) ? $companyData->companyaddresses->first()->countries->name : '' }}
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="pi-data cd-document cd-bg">
                                <button
                                    class="edit_btn {{ frontendPermissionCheck('profile.edit') === false ? 'd-none' : 'd-block' }}"
                                    data-bs-toggle="modal" data-bs-target="#companyDocModal" title="profile-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12">
                                        <g id="Group_20537" data-name="Group 20537" transform="translate(-12916 438)">
                                            <g id="Group_20537-2" data-name="Group 20537"
                                                transform="translate(12916 -438)">
                                                <path id="Path_39675" data-name="Path 39675"
                                                    d="M1.2,13.8l2.52,2.52L0,17.52Z" transform="translate(0 -5.52)"
                                                    fill="#32ae59" />
                                                <rect id="Rectangle_19281" data-name="Rectangle 19281" width="8.28"
                                                    height="3.6" transform="translate(2.043 7.418) rotate(-45)"
                                                    fill="#32ae59" />
                                                <path id="Path_39676" data-name="Path 39676"
                                                    d="M17.66,2.7l-.54.54L14.6.72l.54-.54a.58.58,0,0,1,.84,0l1.68,1.68A.58.58,0,0,1,17.66,2.7Z"
                                                    transform="translate(-5.84 0)" fill="#32ae59" />
                                            </g>
                                        </g>
                                    </svg>
                                </button>

                                <h3 class="profiles-inner-title">Company Documents</h3>
                                <ul class="pi-list">
                                    @if (!empty($companyData->companydocuments) && count($companyData->companydocuments) > 0)
                                        <li class="pi-item">
                                            <strong>TRADE LICENSE</strong>
                                            <ul class="cd-doc-list">

                                                @foreach ($companyData->companydocuments as $value)
                                                    @if ($value->document_type == \App\Models\CompanyDocument::TRADE_LICENSE && $value->file_name)
                                                        @php
                                                            $fileExtension = pathinfo($value->file_name, PATHINFO_EXTENSION);
                                                            if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                            {
                                                                $trandLicenseFile = ($fileExtension === 'pdf') ? asset('assets/images/pdf.png') : asset('assets/images/doc.png');
                                                            } else {
                                                                $trandLicenseFile = $value->file_name;
                                                            }
                                                        @endphp
                                                        <li class="cd-doc-item">
                                                            @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                                <a href="{{ $value->file_name }}" target="_blank"
                                                                    class="a-doc-item" data-id="{{ $value->id }}"
                                                                    title="TRADE LICENSE">
                                                            @endif
                                                            <picture>
                                                                <img src="{{ $trandLicenseFile }}"
                                                                    alt="file image" width="37" height="46"
                                                                    class="{{ ($fileExtension != 'pdf'  || $fileExtension != 'doc' || $fileExtension != 'docx') ? 'imagepop' : '' }}">
                                                            </picture>
                                                            @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                                </a>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                    @if (!empty($companyData->companydocuments) && count($companyData->companydocuments) > 0)
                                        <li class="pi-item">
                                            <strong>ESTABLISHMENT CARD</strong>
                                            <ul class="cd-doc-list">
                                                @if (!empty($companyData->companydocuments))
                                                    @foreach ($companyData->companydocuments as $value)
                                                        @if ($value->document_type == \App\Models\CompanyDocument::ESTABLISHMENT && $value->file_name)
                                                            @php
                                                                $fileExtension = pathinfo($value->file_name, PATHINFO_EXTENSION);
                                                                if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                                {
                                                                    $establishmentFile = ($fileExtension === 'pdf') ? asset('assets/images/pdf.png') : asset('assets/images/doc.png');
                                                                } else {
                                                                    $establishmentFile = $value->file_name;
                                                                }
                                                            @endphp

                                                            <li class="cd-doc-item">
                                                                @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                                    <a href="{{ $value->file_name }}" target="_blank"
                                                                        class="a-doc-item" data-id="{{ $value->id }}"
                                                                        title="ESTABLISHMENT CARD">
                                                                @endif
                                                                <picture>
                                                                    <img src="{{ $establishmentFile }}"
                                                                        alt="file image" width="37" height="46"
                                                                        class="{{ ($fileExtension != 'pdf'  || $fileExtension != 'doc' || $fileExtension != 'docx') ? 'imagepop' : '' }}">
                                                                </picture>
                                                                @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                                    </a>
                                                                @endif
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="pi-data cd-industry cd-bg">
                                <button
                                    class="edit_btn {{ frontendPermissionCheck('profile.edit') === false ? 'd-none' : 'd-block' }}"
                                    data-bs-toggle="modal" data-bs-target="#industryModal" title="profile-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12">
                                        <g id="Group_20537" data-name="Group 20537" transform="translate(-12916 438)">
                                            <g id="Group_20537-2" data-name="Group 20537"
                                                transform="translate(12916 -438)">
                                                <path id="Path_39675" data-name="Path 39675"
                                                    d="M1.2,13.8l2.52,2.52L0,17.52Z" transform="translate(0 -5.52)"
                                                    fill="#32ae59" />
                                                <rect id="Rectangle_19281" data-name="Rectangle 19281" width="8.28"
                                                    height="3.6" transform="translate(2.043 7.418) rotate(-45)"
                                                    fill="#32ae59" />
                                                <path id="Path_39676" data-name="Path 39676"
                                                    d="M17.66,2.7l-.54.54L14.6.72l.54-.54a.58.58,0,0,1,.84,0l1.68,1.68A.58.58,0,0,1,17.66,2.7Z"
                                                    transform="translate(-5.84 0)" fill="#32ae59" />
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                                @if (!empty($companyData->industry))
                                    <h3 class="profiles-inner-title">Industry</h3>
                                    <h4>{{ optional($companyData)->industry->name ?? '' }}</h4>
                                @endif
                                <small>ACTIVITY SCOPES</small>
                                <ul class="pi-list">

                                    <li class="pi-item">
                                        <strong>SCOPE 1</strong>
                                        <span>
                                            @if (!empty($scopeOne) && count($scopeOne) > 0)
                                                @foreach ($scopeOne as $index => $value)
                                                    @if ($value == 'Flight and Accommodation' || $value == 'Home Office')
                                                        {{ $value }}
                                                        {{ $index < count($scopeOne) - 1 ? ',' : '' }}
                                                    @else
                                                        <a href="#" onclick="emissionModal(this)"
                                                            data-slug="{{ generateSlug($value) }}"
                                                            data-name="{{ $value }}"
                                                            title=" {{ $value }}">
                                                            {{ $value }}
                                                            {{ $index < count($scopeOne) - 1 ? ',' : '' }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </span>
                                    </li>
                                    <li class="pi-item">
                                        <strong>SCOPE 2</strong>
                                        <span>
                                            @if (!empty($scopeTwo) && count($scopeTwo) > 0)
                                                @foreach ($scopeTwo as $index => $value)
                                                    @if ($value == 'Flight and Accommodation' || $value == 'Home Office')
                                                        {{ $value }}
                                                        {{ $index < count($scopeTwo) - 1 ? ',' : '' }}
                                                    @else
                                                        <a href="#" onclick="emissionModal(this)"
                                                            data-slug="{{ generateSlug($value) }}"
                                                            data-name="{{ $value }}"
                                                            title=" {{ $value }}">
                                                            {{ $value }}
                                                            {{ $index < count($scopeTwo) - 1 ? ',' : '' }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </span>
                                    </li>
                                    <li class="pi-item">
                                        <strong>SCOPE 3</strong>
                                        <span>
                                            @if (!empty($scopeThree) && count($scopeThree) > 0)
                                                @foreach ($scopeThree as $index => $value)
                                                    @if ($value == 'Flight and Accommodation' || $value == 'Home Office')
                                                        {{ $value }}
                                                        {{ $index < count($scopeThree) - 1 ? ',' : '' }}
                                                    @else
                                                        <a href="#" onclick="emissionModal(this)"
                                                            data-slug="{{ generateSlug($value) }}"
                                                            data-name="{{ $value }}"
                                                            title=" {{ $value }}">
                                                            {{ $value }}
                                                            {{ $index < count($scopeThree) - 1 ? ',' : '' }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Company Details Modal -->
        <div class="modal fade common-modal datasheet-modal cd-modal" id="companyDetailsModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        title="close"></button>
                    <div class="content-inner">
                        <h2 class="section-title">Company Details</h2>

                        <form enctype="multipart/form-data" action="{{ route('profile.store') }}"
                            id="profile-company-details-form" name="profile-company-details-form" method="post"
                            class="input-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ optional($companyData)->id }}">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="company_name">NAME OF ORGANIZATION <span
                                                class="mandatory-field">*</span></label>
                                        <input type="text" class="form-controal" name="company_name"
                                            id="company_name" value="{{ optional($companyData)->company_name ?? '' }}"
                                            placeholder="ABC Corporation" minlength="3" />
                                        {{-- <span class="error-mgs" id="company_name-error"></span> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="trade_licence_number">TRADE LICENSE NUMBER <span
                                                class="mandatory-field">*</span></label>
                                        <input type="text" class="form-controal" name="trade_licence_number"
                                            id="trade_licence_number"
                                            value="{{ optional($companyData)->trade_licence_number ?? '' }}"
                                            minlength="10" placeholder="XBR8546665GT" />
                                        {{-- <span class="error-mgs" id="trade_licence_number-error"></span> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="no_of_employees">NUMBER OF EMPLOYEES <span
                                                class="mandatory-field">*</span></label>
                                        <div class="no_of_employees-error-cls">
                                            <select name="no_of_employees" id="no_of_employees" title="Select Employees">
                                                @foreach (\App\Models\User::NO_OF_EMPLOYEE as $value)
                                                    <option value="{{ $value }}"
                                                        {{ optional($companyData)->no_of_employees === $value ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <span class="error-mgs" id="no_of_employees-error"></span> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="company_email">EMAIL ADDRESS <span
                                                class="mandatory-field">*</span></label>
                                        <input type="email" class="form-controal" name="company_email"
                                            id="company_email" value="{{ optional($companyData)->company_email ?? '' }}"
                                            minlength="10" placeholder="info@abccorporation.com" />
                                        {{-- <span class="error-mgs" id="company_email-error"></span> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="company_phone">CONTACT NUMBER <span
                                                class="mandatory-field">*</span></label>
                                        <input type="text" class="form-controal" name="company_phone"
                                            id="company_phone" value="{{ optional($companyData)->company_phone ?? '' }}"
                                            placeholder="Enter contact number" id="company_phone" maxlength='15' />
                                        {{-- <span class="error-mgs" id="company_phone-error"></span> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group add-company-logo">
                                        <label for="file">COMPANY LOGO</label>
                                        <div class="in-file form-controal company_logo-error-cls">
                                            <span
                                                id="company-logo-name">{{ !optional($companyData)->file_name || !str_contains(optional($companyData)->company_logo, 'No_image_available.png') ? optional($companyData)->file_name ?? 'Select Company Logo' : 'Select Company Logo' }}</span>
                                            <input type="file" name="company_logo" id="file" accept="image/*"
                                                onchange="companyLogoPreview(this)" />
                                            <label for="file">+ ADD FILE</label>
                                        </div>
                                        <span class="error-note">Accepted File Types: jpeg, jpg, png, webp</span>
                                        {{-- <span class="error-mgs" id="company_logo-error"></span> --}}

                                        <img src="{{ optional($companyData)->company_logo }}" id="company-logo-preview"
                                            height="50" width="50" class="imagepop" alt="company-logo">

                                    </div>
                                </div>
                            </div>
                            <div class="row ca-row">
                                <div class="col-12">
                                    <h3 class="profiles-inner-title">Company Address</h3>
                                </div>
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="address">ADDRESS</label>
                                        <input type="text" class="form-controal" name="address" id="address"
                                            value="@if($companyData && $companyData->companyaddresses && $companyData->companyaddresses->first()){{ $companyData->companyaddresses->first()->address }}@endif"
                                            placeholder="NO 18 Mishui Avenue" />
                                        {{-- <span class="error-mgs" id="address-error"></span> --}}
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="country_id">COUNTRY</label>
                                        <div class="country_id-error-cls">
                                            <select name="country_id" id="country_id" data-live-search="true"
                                                title="Select Country">
                                                @if (count($countryData) > 0)
                                                    @foreach ($countryData as $value)
                                                        <option value="{{ $value['id'] }}"
                                                            @if ($companyData && $companyData->companyaddresses && $companyData->companyaddresses->first()) {{ !empty($companyData->companyaddresses->first()->countries->id) && $companyData->companyaddresses->first()->countries->id == $value['id'] ? 'selected' : '' }} @endif>
                                                            {{ $value['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        {{-- <span class="error-mgs" id="country_id-error"></span> --}}
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="city">CITY</label>
                                        <input type="text" class="form-controal" name="city" id="city"
                                            value="@if($companyData && $companyData->companyaddresses && $companyData->companyaddresses->first()){{ $companyData->companyaddresses->first()->city }}@endif"
                                            minlength="3" placeholder="Gaomi City" />
                                        {{-- <span class="error-mgs" id="city-error"></span> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="btn-wrap">
                                        <a class="back-btn" data-bs-dismiss="modal" title="cancel">CANCEL</a>
                                        <button class="btn-primary" id="profile-company-details-form-btn" title="update">
                                            UPDATE
                                            <picture>
                                                <img src="{{ asset('assets/images/button-arrow.svg') }}"
                                                    alt="button-arrow" width="24" height="24" />
                                            </picture>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Company Documents Modal -->
        <div class="modal fade common-modal cd-modal company-doc-modal" id="companyDocModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        title="close"></button>
                    <div class="content-inner">
                        <h2 class="section-title">Company Documents</h2>
                        <form enctype="multipart/form-data" class="input-form" id="document-update-form"
                            name="document-update-form">
                            @csrf
                            <div class="row">
                                <div class="col-12 com-doc-col">
                                    <div class="com-doc-box">
                                        <strong>TRADE LICENSE</strong>

                                        <ul class="doc-modal-list trade-license-list">
                                            <li>
                                                <label class="doc-fild-add">
                                                    <input type="file" class="form-controal" name="trade_license[]"
                                                        id="trade_license" multiple  accept=".pdf, .doc, .docx, image/*"
                                                        onchange="tradeLicenseNameSet(this)"
                                                        placeholder="select TRADE LICENSE"
                                                        title="select TRADE LICENSE" />
                                                </label>
                                            </li>
                                            @if (!empty($companyData->companydocuments))
                                                @foreach ($companyData->companydocuments as $value)
                                                    @if ($value->document_type == \App\Models\CompanyDocument::TRADE_LICENSE && $value->file_name)
                                                        @php
                                                            $fileExtension = pathinfo($value->file_name, PATHINFO_EXTENSION);
                                                            if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                            {
                                                                $trandLicenseFile = ($fileExtension === 'pdf') ? asset('assets/images/pdf.png') : asset('assets/images/doc.png');
                                                            } else {
                                                                $trandLicenseFile = $value->file_name;
                                                            }
                                                        @endphp
                                                        <li>
                                                            <div class="doc-fild-img">
                                                                <a class="cancal-doc-btn" data-id="{{ $value->id }}"
                                                                    title="cancel">
                                                                    <picture>
                                                                        <img src="{{ asset('assets/images/cancal-icon.svg') }}"
                                                                            alt="cancal image" width="24"
                                                                            height="24" />
                                                                    </picture>
                                                                </a>
                                                                <picture>
                                                                    <img src="{{ $trandLicenseFile }}"
                                                                        alt="file image" width="37" height="46" />
                                                                </picture>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </ul>
                                        <span class="error-note">Accepted File Types: jpeg,png,jpg,webp,pdf,doc and docx</span>
                                    </div>
                                    <div class="com-doc-box">
                                        <strong>ESTABLISHMENT CARD</strong>

                                        <ul class="doc-modal-list establishment-list">
                                            <li>
                                                <label class="doc-fild-add">
                                                    <input type="file" class="form-controal" name="establishment[]"
                                                        id="establishment" multiple  accept=".pdf, .doc, .docx, image/*"
                                                        onchange="establishmentNameSet(this)"
                                                        placeholder="select ESTABLISHMENT CARD" title="select ESTABLISHMENT CARD" />
                                                </label>
                                            </li>
                                            @if (!empty($companyData->companydocuments))
                                                @foreach ($companyData->companydocuments as $value)
                                                    @if ($value->document_type == \App\Models\CompanyDocument::ESTABLISHMENT && $value->file_name)
                                                        @php
                                                            $fileExtension = pathinfo($value->file_name, PATHINFO_EXTENSION);
                                                            if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                            {
                                                                $establishmentFile = ($fileExtension === 'pdf') ? asset('assets/images/pdf.png') : asset('assets/images/doc.png');
                                                            } else {
                                                                $establishmentFile = $value->file_name;
                                                            }
                                                        @endphp
                                                        <li>
                                                            <div class="doc-fild-img">
                                                                <a class="cancal-doc-btn" data-id="{{ $value->id }}"
                                                                    title="cancel">
                                                                    <picture>
                                                                        <img src="{{ asset('assets/images/cancal-icon.svg') }}"
                                                                            alt="cancal image" width="24"
                                                                            height="24" />
                                                                    </picture>
                                                                </a>
                                                                <picture>
                                                                    <img src="{{ $establishmentFile }}"
                                                                        alt="file image" width="37" height="46" />
                                                                </picture>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </ul>
                                        <span class="error-note">Accepted File Types: jpeg,png,jpg,webp,pdf,doc and docx</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="btn-wrap">
                                        <a class="back-btn" data-bs-dismiss="modal" title="cancel">CANCEL</a>
                                        <!-- <a class="back-btn">CANCEL</a> -->
                                        <button class="btn-primary upload-document" id="upload-document" title="update">
                                            UPDATE
                                            <picture>
                                                <img src="{{ asset('assets/images/button-arrow.svg') }}"
                                                    alt="button-arrow" width="24" height="24" />
                                            </picture>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- industry Modal -->
        <div class="modal fade common-modal datasheet-modal cd-modal industry-modal" id="industryModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        title="close"></button>
                    <div class="content-inner">
                        <h2 class="section-title">Industry</h2>

                        <form method="POST" action="{{ route('profile.profile-industry-details.store') }}"
                            id="industry-update-form" name="industry-update-form" class="input-form">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="company_industry_id-error-cls">
                                            <select name="company_industry_id" id="company_industry_id"
                                                title="Company Industry">
                                                @if (count($companyIndustryData) > 0)
                                                    @foreach ($companyIndustryData as $value)
                                                        <option value="{{ $value['id'] }}"
                                                            {{ $companyData->company_industry_id == $value['id'] ? 'selected' : '' }}>
                                                            {{ $value['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row emission-scopes-row">
                                <div class="col-12">
                                    <h3 class="profiles-inner-title">Activity </h3>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <div class="activity-error-cls">
                                            <select name="activity[]" id="activity" class="form-control multi-select"
                                                title="Select emission" multiple>
                                                @if (count($activityData) > 0)
                                                    @forelse ($activityData as $value)
                                                        <option value="{{ $value['id'] }}"
                                                            {{ in_array($value['id'], \Illuminate\Support\Arr::pluck($companyData->companyactivities, 'activity_id')) ? 'selected' : '' }}>
                                                            {{ $value['name'] }}</option>
                                                    @empty
                                                        <option value="" disabled>No emission types available
                                                        </option>
                                                    @endforelse
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="btn-wrap">
                                        <a data-bs-dismiss="modal" class="back-btn" title="cancel">CANCEL</a>
                                        <button class="btn-primary" id="industry-update-form-btn" title="update">
                                            UPDATE
                                            <picture><img src="{{ asset('assets/images/button-arrow.svg') }}"
                                                    alt="button-arrow" width="24" height="24" />
                                            </picture>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- after industry update Modal -->
        <div class="modal fade common-modal datasheet-modal cd-modal after-industry-modal" id="afterIndustryModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        title="close"></button>
                    <div class="content-inner">
                        <h2 class="section-title">Company Details</h2>

                        <form method="POST" action="{{ route('profile.profile-after-industry-details.store') }}"
                            id="after-industry-update-form" name="after-industry-update-form" class="input-form">
                            @csrf
                            <div class="row">
                                <div class="emission-management">
                                    {{-- <div id="loader_industry" class="loader_industry"></div> --}}
                                    {{-- <span class="error-mgs" id="errorMessagesID"></span> --}}
                                </div>
                                <div class="col-md-12 col-12" id="activity-tab-detail">

                                </div>

                                <input type="hidden" name="company_id" value="{{ $companyData->id }}">
                                <input type="hidden" name="user_id" value="{{ $companyData->user_id }}">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="btn-wrap">
                                        <a data-bs-dismiss="modal" class="back-btn" title="cancel">CANCEL</a>
                                        <button class="btn-primary" id="after-industry-update-form-btn" title="update">
                                            UPDATE
                                            <picture>
                                                <img src="{{ asset('assets/images/button-arrow.svg') }}"
                                                    alt="button-arrow" width="24" height="24" />
                                            </picture>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @php
        $staffRoles = \App\Models\UserRole::whereNot('role', 'Company Admin')
            ->where('type', 'Frontend')
            ->pluck('id')
            ->toArray();
    @endphp
    @if (in_array(Auth::guard('web')->user()->user_role_id, $staffRoles))
        <section class="profiles-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="profiles-inner staff-profile">
                            <div class="pi-img-wrap">
                                <div class="pi-img">
                                    <div
                                        class="file-wrap {{ frontendPermissionCheck('profile.edit') === false ? 'd-none' : 'd-block' }}">
                                        <div class="in-file">
                                            {{-- <div id="profile-loader" class="loader"></div> --}}
                                            <label for="profile_picture">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    viewBox="0 0 12 12">
                                                    <g id="Group_20537" data-name="Group 20537"
                                                        transform="translate(-12916 438)">
                                                        <g id="Group_20537-2" data-name="Group 20537"
                                                            transform="translate(12916 -438)">
                                                            <path id="Path_39675" data-name="Path 39675"
                                                                d="M1.2,13.8l2.52,2.52L0,17.52Z"
                                                                transform="translate(0 -5.52)" fill="#32ae59" />
                                                            <rect id="Rectangle_19281" data-name="Rectangle 19281"
                                                                width="8.28" height="3.6"
                                                                transform="translate(2.043 7.418) rotate(-45)"
                                                                fill="#32ae59" />
                                                            <path id="Path_39676" data-name="Path 39676"
                                                                d="M17.66,2.7l-.54.54L14.6.72l.54-.54a.58.58,0,0,1,.84,0l1.68,1.68A.58.58,0,0,1,17.66,2.7Z"
                                                                transform="translate(-5.84 0)" fill="#32ae59" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            </label>
                                            <input type="file" name="profile_picture" id="profile_picture"
                                                onchange="profilePictureChange(this)" accept="image/*"
                                                placeholder="select image" title="select image" />

                                        </div>
                                    </div>
                                    <picture>
                                        <img src="{{ !empty(optional($companyDataForStaff->user)->profile_picture) ? optional($companyDataForStaff->user)->profile_picture : asset('assets/images/No_image_available.png') }}"
                                            id="profile_image" alt="profile image" width="130" height="130" />
                                    </picture>
                                </div>
                                <strong>Profile Photo</strong>
                            </div>
                            <div class="pi-data pi-col1 cd-bg">
                                <button
                                    class="edit_btn {{ frontendPermissionCheck('profile.edit') === false ? 'd-none' : 'd-flex' }}"
                                    data-bs-toggle="modal" data-bs-target="#companyDetailsModal" title="profile-update">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12">
                                        <g id="Group_20537" data-name="Group 20537" transform="translate(-12916 438)">
                                            <g id="Group_20537-2" data-name="Group 20537"
                                                transform="translate(12916 -438)">
                                                <path id="Path_39675" data-name="Path 39675"
                                                    d="M1.2,13.8l2.52,2.52L0,17.52Z" transform="translate(0 -5.52)"
                                                    fill="#32ae59" />
                                                <rect id="Rectangle_19281" data-name="Rectangle 19281" width="8.28"
                                                    height="3.6" transform="translate(2.043 7.418) rotate(-45)"
                                                    fill="#32ae59" />
                                                <path id="Path_39676" data-name="Path 39676"
                                                    d="M17.66,2.7l-.54.54L14.6.72l.54-.54a.58.58,0,0,1,.84,0l1.68,1.68A.58.58,0,0,1,17.66,2.7Z"
                                                    transform="translate(-5.84 0)" fill="#32ae59" />
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                                <ul class="pi-list cd-list">
                                    <li class="pi-item">
                                        <strong>Name</strong>
                                        <span>{{ ucwords($user->name) ?? '' }}</span>
                                    </li>
                                    <li class="pi-item">
                                        <strong>Employee Id</strong>
                                        <span>{{ ucwords($user->employee_id) ?? '' }}</span>
                                    </li>
                                    <li class="pi-item">
                                        <strong>Organization</strong>
                                        <span>{{ !empty($companyDataForStaff->company) ? ucwords($companyDataForStaff->company->company_name) : '' }}</span>
                                    </li>
                                    <li class="pi-item">
                                        <strong>Email Address</strong>
                                        <span>{{ $user->email ?? '' }}</span>
                                    </li>
                                    <li class="pi-item">
                                        <strong>Contact Number</strong>
                                        <span>{{ $user->contact_number ?? '' }}</span>
                                    </li>
                                    <li class="pi-item">
                                        <strong>Role</strong>
                                        <span>{{ optional($user->role)->role }}</span>
                                    </li>
                                    <li class="pi-item">
                                        <strong>Status</strong>
                                        <span>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Company Details Modal -->
        <div class="modal fade common-modal datasheet-modal cd-modal" id="companyDetailsModal">
            <div class="modal-dialog modal-dialog-centered staff-profile-modal">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        title="close"></button>
                    <div class="content-inner">
                        <h2 class="section-title">Profile Information</h2>

                        <form enctype="multipart/form-data" action="{{ route('profile.staff-profile-details.store') }}"
                            id="staff-profile-form" name="staff-profile-form" method="post" class="input-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">EMAIL ADDRESS</label>
                                        <input type="email" class="form-controal" name="email" id="email"
                                            value="{{ $user->email ?? '' }}" readonly />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">NAME</label>
                                        <input type="text" class="form-controal errorNameCls" name="name"
                                            id="name" value="{{ $user->name ?? '' }}" placeholder="Enter name" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="company_phone">CONTACT NUMBER</label>
                                        <input type="text" class="form-controal errorContactNumberCls"
                                            name="contact_number" placeholder="Enter contact number"
                                            value="{{ $user->contact_number ?? '' }}" id="company_phone" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="btn-wrap">
                                        <a class="back-btn" data-bs-dismiss="modal" title="cancel">CANCEL</a>
                                        <button class="btn-primary" id="staff-profile-form-btn" title="update">
                                            UPDATE
                                            <picture>
                                                <img src="{{ asset('assets/images/button-arrow.svg') }}"
                                                    alt="button-arrow" width="24" height="24" />
                                            </picture>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @include('common-modal.delete-modal')
    @include('common-modal.emission-modal')
    @include('common-modal.image-preview-modal')
    <style>

    </style>
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest(
        \App\Http\Requests\Frontend\CreateCompanyDetailStepOneRequest::class,
        '#step-one-form',
    ) !!}

    <script type="text/javascript">
        const emissionRoute = "{{ route('emission-data') }}"
        const companyId = "{{ $companyData->id }}";

        var uploadDocumentButton = $('#upload-document');
        uploadDocumentButton.prop('disabled', true);
        $('#companyDetailsModal').on('hidden.bs.modal', function(e) {})
        $('#profile-company-details-form').submit(function(e) {
            e.preventDefault();
            var formAction = $(this).attr('action');
            var formdata = new FormData(this)
            var button = $('#profile-company-details-form-btn');
            button.prop('disabled', true);
            button.html('Processing...');
            resetErrorMessages();
            $.ajax({
                url: formAction,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 'true') {
                        button.prop('disabled', false);
                        button.html('UPDATE');

                        $('#companyDetailsModal').modal('hide');
                        setReturnMsg("Success", response.message);
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 4000);
                    } else {
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        setReturnMsg("danger", response.message);
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        companyDetailError(xhr.responseJSON.errors);
                    }

                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    }
                }
            });
        });

        function reloadPage() {
            return location.reload();
        }

        function removeStaffValidation() {
            $('#errorName').remove();
            $('#errorContactNumber').remove();
        }
        $('#staff-profile-form').submit(function(e) {
            e.preventDefault();
            var formAction = $(this).attr('action');
            var formdata = new FormData(this)
            var button = $('#staff-profile-form-btn');
            button.prop('disabled', true);
            button.html('Processing...');
            $.ajax({
                url: formAction,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.errors) {
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        $('.error-mgs').html('');
                        removeStaffValidation();
                        if (response.errors.name) {
                            $('.errorNameCls').after('<span class="error-mgs" id="errorName">' +
                                response.errors.name[0] + '</span>');
                        }
                        if (response.errors.contact_number) {
                            $('.errorContactNumberCls').after(
                                '<span class="error-mgs" id="errorContactNumber">' + response.errors
                                .contact_number[0] + '</span>');
                        }
                    }
                    if (response.success) {
                        $('.error-mgs').html('');
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        setReturnMsg("Success", response.success);
                        $('#companyDetailsModal').modal('hide');
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 4000);
                    }
                    if (response.error_update) {
                        $('.error-mgs').html('');
                        removeStaffValidation();
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        setReturnMsg("danger", response.error_update);
                    }
                    if (response.catch_error) {
                        $('.error-mgs').html('');
                        removeStaffValidation();
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        setReturnMsg("danger", response.catch_error);
                    }
                    if (response.user_notfound) {
                        $('.error-mgs').html('');
                        removeStaffValidation();
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        setReturnMsg("danger", response.user_notfound);
                    }
                },
                beforeSend: function() {
                    $('#loader').css('display', 'inline-flex');
                },
                complete: function() {
                    $('#loader').css('display', 'none');
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle the HTTP status code here
                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    }
                },
            });
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

        function profilePictureChange(input) {
            const maxFileSize = 15 * 1024 * 1024; // 15MB in bytes
            const fileSize = input.files[0].size;

            if (fileSize > maxFileSize) {
                setReturnMsg("danger", 'File size exceeds 15MB. Please choose a smaller file.');
                return;
            }

            if (!isValidImageFileType(input.files[0])) {
                setReturnMsg("danger", 'Only upload jpeg, jpg, png, webp files.');
                return;
            }

            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var fd = new FormData();

            // Append data 
            fd.append('profile_picture', input.files[0]);
            fd.append('_token', CSRF_TOKEN);

            $.ajax({
                url: "{{ route('profile.profile-image-update') }}",
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'true') {
                        setReturnMsg("Success", response.message);
                        $('#profile_image').attr('src', response.data);
                    } else {
                        setReturnMsg("danger", response.message);
                    }
                },
                beforeSend: function() {
                    $('#loader').css('display', 'inline-flex');
                },
                complete: function() {
                    $('#loader').css('display', 'none');
                },
                error: function(xhr, status, error) {
                    $('#loader').css('display', 'none');
                    // if (xhr.status === 422) {
                    setReturnMsg("danger", xhr.responseJSON.message);
                    // }

                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    }
                }
            });
        }

        function isValidImageFileType(file) {
            // Allowed image file types
            var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            return allowedTypes.includes(file.type);
        }

        async function setPlaceholder(input, className) {
            $('#loader').css('display', 'inline-flex');
            const previewSelector = `.${className}`;
            const $preview = $(previewSelector);
            const allowedTypes = new Set(['application/pdf', 'image/png',
                'image/jpeg','image/jpg','application/msword', // DOC
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // DOCX
            ]); // Use a Set for faster lookups
            const allowedSizeInKB = 15360; // 15MB in kilobytes
            const files = input.files;

            if ([...files].some(file => !allowedTypes.has(file.type))) {
                setReturnMsg("danger", "Invalid file type. Only PDF,DOC,DOCX PNG, WEBP, and JPG files are allowed.");
                $('#loader').css('display', 'none');
                return;
            }

            const exceedsSizeLimit = [...files].some(file => (file.size / 1024) > allowedSizeInKB);

            if (exceedsSizeLimit) {
                setReturnMsg("danger", "Please upload files less than 15 MB.");
                $('#loader').css('display', 'none');
                return;
            }

            // try {
            //     const response = await uploadKycDocument(files);
            //     if (response.status === 'true') {
            //         setReturnMsg("Success", response.message);
            //         $('#loader').css('display', 'none');
            //         setTimeout(() => location.reload(), 1000);
            //         // Handle the response from the server if needed
            //     } else {
            //         $('#loader').css('display', 'none');
            //         console.error("Upload failed with status: " + response.status);
            //     }
            // } catch (error) {
            //     $('#loader').css('display', 'none');
            //     setReturnMsg("danger", 'File to large');
            //     console.error(error);
            //     return;
            // } finally {}

            let placeholderImageName = '';
            for (const file of files) {
                if (file.type === 'application/pdf' || file.type === 'application/msword' || file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    try {
                        const response = (file.type === 'application/pdf') ?  await fetch("{{ asset('assets/images/pdf.png') }}") : await fetch("{{ asset('assets/images/doc.png') }}");
                        if (response.ok) {
                            const imageUrl = URL.createObjectURL(await response.blob());
                            const imagePreview = createImagePreview(imageUrl);
                            $preview.append(imagePreview);
                        } else {
                            handleFetchError();
                        }
                    } catch (error) {
                        $('#loader').css('display', 'none');
                        handleFetchError(error);
                    }
                } else {
                    const imagePreview = await createImagePreviewFromFile(file);
                    $preview.append(imagePreview);
                }
                placeholderImageName += file.name;

                if (files.length > 1) {
                    placeholderImageName += ', ';
                }
            }

            $preview.attr('placeholder', placeholderImageName);
            uploadDocumentButton.prop('disabled', false);
            $('#loader').css('display', 'none');
        }

        function createImagePreview(imageUrl) {
            return `
                    <li id="attachment-li">
                        <div class="doc-fild-img">
                            <a class="cancal-doc-btn" title="cancel">
                                <picture>
                                    <img src="{{ asset('assets/images/cancal-icon.svg') }}"  alt="cancel image" width="24" height="24">
                                </picture>
                            </a>
                            <picture>
                                <img src="${imageUrl}" height="20px" width="20px" alt="image">
                            </picture>
                        </div>
                    </li>
                `;
        }

        function removeHtml(className) {
            return $('#'.className).find('li.attachment-li').remove();
        }

        function createImagePreviewFromFile(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const imagePreview = createImagePreview(event.target.result);
                    resolve(imagePreview);
                };
                reader.onerror = function(error) {
                    reject(error);
                };
                reader.readAsDataURL(file);
            });
        }

        function handleFetchError(error) {
            setReturnMsg("danger", 'Failed to fetch PDF image');
            console.error('Failed to fetch PDF image', error);
        }

        function tradeLicenseNameSet(input) {
            setPlaceholder(input, 'trade-license-list');
        }

        function establishmentNameSet(input) {
            setPlaceholder(input, 'establishment-list');
        }

        function kycDocumentUpdate(files) {
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var fd = new FormData();

            // Append data 
            fd.append('', files);
            fd.append('_token', CSRF_TOKEN);

            $.ajax({
                url: "{{ route('profile.profile-image-update') }}",
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'true') {
                        setReturnMsg("Success", response.message);
                        $('#profile_image').attr('src', response.data);
                    } else {
                        setReturnMsg("danger", response.message);
                    }
                },
                error: function(xhr, status, error) {
                    setReturnMsg("danger", xhr.responseJSON.message);
                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    }
                }
            });
        }


        $(document).on("click", ".cancal-doc-btn", function() {
            if ($(this).closest('a.cancal-doc-btn').data('id') === undefined) {
                $(this).parent().parent().remove();
            } else {
                $("#deleterecordModel").modal('show');
                $(".deleterecordbtn").attr('data-id', $(this).closest('a.cancal-doc-btn').data('id'));
                $(".delete-modal-title").text("Are you sure you want to remove this document?");
                $(".delete-modal-body").html(
                    "<p>This will delete document permanently. You cannot undo this action.</p>");
            }
        });

        $(".deleterecordbtn").click(function() {
            $.ajax({
                url: "{{ route('profile.profile-image-remove') }}",
                method: 'post',
                data: {
                    id: $(this).attr('data-id')
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == 'true') {
                        $('.cancal-doc-btn[data-id="' + response.data.id + '"]').parent().parent()
                            .remove();
                        $('.a-doc-item[data-id="' + response.data.id + '"]').remove();
                        setReturnMsg("Success", response.message);
                        $('#deleterecordModel').modal('toggle');
                    } else {
                        setReturnMsg("danger", response.message);
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        setReturnMsg("danger", xhr.responseJSON.message);
                    }
                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    }
                }
            });
        });


        $('#document-update-form').submit(async function(e) {
            e.preventDefault(); // Prevent the form from submitting normally
            var button = $('#upload-document');
            button.prop('disabled', true);
            button.html('Processing...');

            try {
                const response = await uploadKycDocument();
                if (response.status === 'true') {
                    setReturnMsg("Success", response.message);
                    $('#loader').css('display', 'none');
                    button.prop('disabled', false);
                    button.html('UPDATE');
                    setTimeout(() => location.reload(), 1000);
                    // Handle the response from the server if needed
                } else {
                    $('#loader').css('display', 'none');
                    console.error("Upload failed with status: " + response.status);
                    button.prop('disabled', false);
                    button.html('UPDATE');
                }
            } catch (error) {
                $('#loader').css('display', 'none');
                setReturnMsg("danger", 'File to large');
                console.error(error);
                button.prop('disabled', false);
                button.html('UPDATE');
                return;
            } finally {}

            // try {
            //     const response = await uploadDocument();
            //     if (response.status === 'true') {
            //         setReturnMsg("Success", response.message);
            //         setTimeout(() => location.reload(), 1000);
            //         // Handle the response from the server if needed
            //     } else {
            //         console.error("Upload failed with status: " + response.status);
            //     }
            // } catch (error) {
            //     console.error(error);
            // } finally {
            //     button.prop('disabled', false);
            //     button.html('UPDATE');
            // }
        });


        function uploadKycDocument() {
            return new Promise((resolve, reject) => {
                var formData = new FormData($('#document-update-form')[0]);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "{{ route('profile.company-document-update') }}", true);

                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;

                    }
                };

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        if (xhr.getResponseHeader('content-type').indexOf('application/json') !== -1) {
                            const response = JSON.parse(xhr.response);
                            resolve(response);
                        } else {
                            reject("Response is not in JSON format");
                        }
                    } else {
                        reject("Upload failed with status: " + xhr.status);
                    }
                };

                xhr.send(formData);
            });
        }

        function uploadDocument() {
            return new Promise((resolve, reject) => {
                var formData = new FormData($('#document-update-form')[0]); // Use [0] to access the first element
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "{{ route('profile.company-document-update') }}", true);

                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                    }
                };

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.response);
                        resolve(response);
                    } else {
                        reject("Upload failed with status: " + xhr.status);
                    }
                };

                xhr.send(formData);
            });
        }

        $('.company-document-cancel').click(function() {
            $('#deleterecordModel').modal('toggle');
        })

        //Company Logo Preview
        function companyLogoPreview(input) {
            const maxFileSize = 15 * 1024 * 1024; // 15MB in bytes
            const fileSize = input.files[0].size;
            const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];

            if (fileSize > maxFileSize) {
                setReturnMsg("danger", 'File size exceeds 15MB. Please choose a smaller file.');
                return;
            }
            const fileType = input.files[0].type;
            if (!allowedTypes.includes(fileType)) {
                setReturnMsg("danger", 'Only upload jpeg, jpg, png, webp files.');
                return;
            }
            $('#company-logo-name').text(input.files[0].name);
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#company-logo-preview').attr('src', event.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }

        //Company detail Update form error message set
        function companyDetailError(errors) {
            var errorKeys = ['company_name', 'trade_licence_number', 'no_of_employees', 'company_email', 'company_phone',
                'company_logo', 'address', 'country_id', 'city'
            ];

            for (var key of errorKeys) {
                if (key == "country_id") {
                    var errorElement = $('.country_id-error-cls');
                } else if (key == "no_of_employees") {
                    var errorElement = $('.no_of_employees-error-cls');
                } else if (key == "company_logo") {
                    var errorElement = $('.company_logo-error-cls');
                } else {
                    var errorElement = $('input[name="' + key + '"]');
                }
                if (errors[key]) {
                    errorElement.after('<span class="error-mgs" id="' + key + '-error">' + errors[key][0] + '</span>');
                }
            }
        }

        //Company detail Update form error message reset
        function resetErrorMessages() {
            var errorKeys = ['company_name', 'trade_licence_number', 'no_of_employees', 'company_email', 'company_phone',
                'company_logo', 'address', 'country_id', 'city'
            ];

            for (var key of errorKeys) {
                $('#' + key + '-error').html('');
            }
        }

        $(document).ready(function() {
            $('#address-text').text(function(_, text) {
                return text.replace(/\s+,/g, ',');
            });
        });

        $('#afterIndustryModal').on('hidden.bs.modal', function(e) {
            $('#errorMessagesID').html('');
        });

        $('#industry-update-form').submit(function(e) {
            e.preventDefault();
            var formAction = $(this).attr('action');
            var formdata = new FormData(this)
            var button = $('#industry-update-form-btn');
            button.prop('disabled', true);
            button.html('Processing...');
            resetErrorMessagesIndustry();
            $.ajax({
                url: formAction,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response) {

                    if (response.status == 'true') {
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        if (response.selectedActivityFlag == true) {
                            $('#industryModal').modal('hide');
                            $('#errorMessagesID').html('');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            $('#industryModal').modal('hide');
                            $('#errorMessagesID').html('');
                            $('#afterIndustryModal').modal('show');
                            activityTab();
                        }
                        setReturnMsg("Success", response.message);
                    } else {
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        setReturnMsg("danger", response.message);
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        companyIndustryError(xhr.responseJSON.errors);
                    }

                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    }
                }
            });
        });

        $('#after-industry-update-form').submit(function(e) {
            e.preventDefault();
            var formAction = $(this).attr('action');
            var formdata = new FormData(this)
            var button = $('#after-industry-update-form-btn');
            button.prop('disabled', true);
            button.html('Processing...');
            resetErrorMessagesIndustry();
            $.ajax({
                url: formAction,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#errorMessagesID').html('');
                    if (response.status == 'true') {
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        $('#afterIndustryModal').modal('hide');
                        setReturnMsg("Success", response.message);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        setReturnMsg("danger", response.message);
                    }
                },
                beforeSend: function() {
                    $('#loader').css('display', 'inline-flex');
                },
                complete: function() {
                    $('#loader').css('display', 'none');
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        $('#errorMessagesID').html('');
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = [];
                        $.each(errors, function(field, messages) {
                            errorMessages.push(messages.join(
                                ', ')); // Push the joined messages into the errorMessages array
                        });
                        var errorMessageText = errorMessages.join(', ');
                        $('#errorMessagesID').html(
                            'Please select at least one emission for these activities: ' +
                            errorMessageText);
                    }

                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    }
                }
            });
        });

        function activityTab() {
            $.ajax({
                url: "{{ route('profile.set-activity') }}",
                type: 'get',
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#activity-tab-detail').html(response);


                    $(".checkbox-main").mCustomScrollbar({
                        theme: "dark-3",
                        scrollButtons: {
                            enable: false
                        }
                    });


                },
                beforeSend: function() {
                    $('#loader').css('display', 'inline-flex');
                },
                complete: function() {
                    $('#loader').css('display', 'none');
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        setReturnMsg("danger", xhr.responseJSON.errors);
                    }

                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    }
                }
            });
        }

        function companyIndustryError(errors) {
            var errorKeys = ['company_industry_id', 'activity'];

            for (var key of errorKeys) {
                var errorElement = $('.' + key + '-error-cls');
                if (errors[key]) {
                    errorElement.after('<span class="error-mgs" id="' + key + '-error">' + errors[key][0] + '</span>');
                }
            }
        }

        function resetErrorMessagesIndustry() {
            var errorKeys = ['company_industry_id', 'activity'];

            for (var key of errorKeys) {
                $('#' + key + '-error').remove();
            }
        }
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/emission-modal.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('assets/js/contact-number-validation.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('assets/js/char-length-validation.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/image-preview.js') }}"></script>
@endsection
