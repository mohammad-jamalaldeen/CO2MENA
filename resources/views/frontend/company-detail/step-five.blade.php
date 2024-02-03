@extends('frontend.layouts.app')
@section('title')
    Company Details
@endsection
@section('content')
    <section class="preview">
        <div class="container-fluid">
            <div class="bg-main">
                <form method="post" id="step-five-form" novalidate="" action="{{ route('company-detail-step-five.create') }}">
                    @csrf()
                    <div class="company_detail">
                        <div class="details">
                            <div class="logo-and-title">
                                <div class="title">
                                    <h3>Company Details</h3>
                                </div>
                                <div class="logo">
                                    <picture>
                                        <a href="{{ $companyData->company_logo }}" target="_blank" title="Company Logo">
                                            <img src="{{ $companyData->company_logo ?? '' }}" alt="company-logo"
                                                width="84" height="28">
                                        </a>
                                    </picture>
                                </div>
                            </div>

                            <div class="comany-detail-info">
                                <div class="info">
                                    <ul>
                                        <li>
                                            <strong>Name Of Organization</strong>
                                            <span>{{ $companyData->company_name ?? '' }}</span>
                                        <li>
                                            <strong>Registration Number</strong>
                                            <span>{{ $companyData->company_account_id }}</span>
                                        </li>
                                        <li>
                                            <strong>Number Of Employees</strong>
                                            <span>{{ $companyData->no_of_employees ?? '' }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="email-and-tel">
                                    <ul>
                                        <li>
                                            <strong>Email Address</strong>
                                            <span>
                                                <a href="mailto:{{ $companyData->company_email ?? '' }}"
                                                    title="Company email">{{ $companyData->company_email ?? '' }}</a>
                                            </span>
                                        </li>
                                        <li>
                                            <strong>Contact Number</strong>
                                            <span>
                                                <a href="tel:{{ $companyData->company_phone ?? '' }}"
                                                    title="Company phone number">{{ $companyData->company_phone ?? '' }}</a>
                                            </span>
                                        </li>
                                        <li>
                                            <strong>Company Address</strong>
                                            <span id="address-text">
                                                @if ($companyData && $companyData->companyaddresses && $companyData->companyaddresses->first())
                                                    {{ isset($companyData->companyaddresses->first()->address) ? $companyData->companyaddresses->first()->address.',' : ''  }}
                                                @endif
                                                @if ($companyData && $companyData->companyaddresses && $companyData->companyaddresses->first())
                                                    {{ isset($companyData->companyaddresses->first()->city) ? $companyData->companyaddresses->first()->city.',' : '' }}
                                                @endif
                                                @if ($companyData && $companyData->companyaddresses && $companyData->companyaddresses->first())
                                                    {{ isset($companyData->companyaddresses->first()->countries->name) ? $companyData->companyaddresses->first()->countries->name : '' }}
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="company_documents-and-industry">
                        <div class="main">
                            <div class="comapny-document-details">
                                <div class="company_documents">
                                    <div class="title">
                                        <h3>Company Documents</h3>
                                    </div>
                                    <div class="trade-licence">
                                        <h4>TRADE LICENSE *</h4>
                                        <ul>
                                            @if (!empty($companyData->companydocuments))
                                                @foreach ($companyData->companydocuments as $value)
                                                    @if ($value->document_type == \App\Models\CompanyDocument::TRADE_LICENSE && $value->file_name)
                                                        <li>
                                                            @php
                                                                $fileExtension = pathinfo($value->file_name, PATHINFO_EXTENSION);
                                                                if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx') {
                                                                    $trandLicenseFile = $fileExtension === 'pdf' ? asset('assets/images/pdf.png') : asset('assets/images/doc.png');
                                                                } else {
                                                                    $trandLicenseFile = $value->file_name;
                                                                }
                                                            @endphp
                                                            @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                                <a href="{{ $value->file_name }}" target="_blank"
                                                                    title="Company documents">
                                                            @endif

                                                            <picture>
                                                                <img src="{{ $trandLicenseFile }}" alt="file"
                                                                    width="37" height="46"
                                                                    class="{{ $fileExtension != 'pdf' || $fileExtension != 'doc' || $fileExtension != 'docx' ? 'imagepop' : '' }}">
                                                            </picture>

                                                            @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                                </a>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                        <h4>ESTABLISHMENT CARD</h4>
                                        <ul class="establishment-card">
                                            @if (!empty($companyData->companydocuments))
                                                @foreach ($companyData->companydocuments as $value)
                                                    @if ($value->document_type == \App\Models\CompanyDocument::ESTABLISHMENT && $value->file_name)
                                                        <li>


                                                            @php
                                                                $fileExtension = pathinfo($value->file_name, PATHINFO_EXTENSION);
                                                                if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx') {
                                                                    $establisgmentFile = $fileExtension === 'pdf' ? asset('assets/images/pdf.png') : asset('assets/images/doc.png');
                                                                } else {
                                                                    $establisgmentFile = $value->file_name;
                                                                }
                                                            @endphp
                                                            @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                                <a href="{{ $value->file_name }}" target="_blank"
                                                                    title="Company documents">
                                                            @endif

                                                            <picture>
                                                                <img src="{{ $establisgmentFile }}" alt="file"
                                                                    width="37" height="46"
                                                                    class="{{ $fileExtension != 'pdf' || $fileExtension != 'doc' || $fileExtension != 'docx' ? 'imagepop' : '' }}">
                                                            </picture>

                                                            @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                                </a>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="industry">
                                <div class="title">
                                    <h3>Industry</h3>
                                    <h4 class="sub-title">{{ $companyData->industry->name ?? '' }}</h4>
                                </div>
                                <div class="emission-scopes">
                                    <h4>Emission Scopes</h4>
                                    <div class="scope">
                                        <h4>SCOPE 1</h4>
                                        <p>
                                            @if (count($scopeOne) > 0)
                                                @foreach ($scopeOne as $index => $value)
                                                    @if ($value == 'Flight and Accommodation' || $value == 'Home Office')
                                                        {{ $value }}
                                                        {{ $index < count($scopeOne) - 1 ? ',' : '' }}
                                                    @else
                                                        <a href="#" onclick="emissionModal(this)"
                                                            data-slug="{{ generateSlug($value) }}"
                                                            data-name="{{ $value }}" title="{{ $value }}">
                                                            {{ $value }}
                                                            {{ $index < count($scopeOne) - 1 ? ',' : '' }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </p>
                                    </div>
                                    <div class="scope">
                                        <h4>SCOPE 2</h4>
                                        <p>
                                            @if (count($scopeTwo) > 0)
                                                @foreach ($scopeTwo as $index => $value)
                                                    @if ($value == 'Flight and Accommodation' || $value == 'Home Office')
                                                        {{ $value }}
                                                        {{ $index < count($scopeTwo) - 1 ? ',' : '' }}
                                                    @else
                                                        <a href="#" onclick="emissionModal(this)"
                                                            data-slug="{{ generateSlug($value) }}"
                                                            data-name="{{ $value }}" title="{{ $value }}">
                                                            {{ $value }}
                                                            {{ $index < count($scopeTwo) - 1 ? ',' : '' }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </p>
                                    </div>
                                    <div class="scope">
                                        <h4>SCOPE 3</h4>
                                        <p>
                                            @if (count($scopeThree) > 0)
                                                @foreach ($scopeThree as $index => $value)
                                                    @if ($value == 'Flight and Accommodation' || $value == 'Home Office')
                                                        {{ $value }}
                                                        {{ $index < count($scopeThree) - 1 ? ',' : '' }}
                                                    @else
                                                        <a href="#" onclick="emissionModal(this)"
                                                            data-slug="{{ generateSlug($value) }}"
                                                            data-name="{{ $value }}" title="{{ $value }}">
                                                            {{ $value }}
                                                            {{ $index < count($scopeThree) - 1 ? ',' : '' }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-wrap">
                        <div class="button-row previous">
                            <a class="btn-primary"
                                href="{{ $selectedActivityTab == true ? route('company-detail-step-three.index') : route('company-detail-step-four.index') }}">
                                <picture>
                                    <img src="{{ asset('assets/images/Arrow-left.svg') }}" alt="button-arrow"
                                        width="24" height="24">
                                </picture>
                                PREVIOUS
                            </a>
                        </div>
                        <div class="button-row continue">

                            <button type="submit" class="btn-primary" title="go-to-dashboard">GO TO DASHBOARD
                                <picture>
                                    <img src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow"
                                        width="24" height="24">
                                </picture>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="modal fade common-modal privacy-modal" id="termsPrivacyModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="close"></button>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <p>{!! isset($page->title) ? $page->title : '' !!}</p>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body custome-scrollbar-m">
                    <div id="checkboxError" style="color: red;"></div>
                    <p>{!! isset($page->content) ? $page->content : '' !!}</p>
                    <div class="custome-checkbox">
                        <label class="checkbox" for="agreeCheckbox">
                            <input type="checkbox" class="form-check-input" id="agreeCheckbox">I agree to the Terms and
                            Privacy<span class="checkmark"></span>
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="proceedToDashboard"
                        title="proceedtodashboard">Proceed to Dashboard
                        <picture>
                            <img src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow" width="24"
                                height="24">
                        </picture>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('common-modal.emission-modal')
    @include('common-modal.image-preview-modal')
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        const emissionRoute = "{{ route('emission-data') }}"
        const companyId = "{{ $companyData->id }}"
        document.getElementById('agreeCheckbox').addEventListener('change', function() {
            var proceedButton = document.getElementById('proceedToDashboard');
            proceedButton.disabled = !this.checked;
        });

        document.getElementById('proceedToDashboard').addEventListener('click', function() {
            if (document.getElementById('agreeCheckbox').checked) {
                document.getElementById('step-five-form').submit();
            } else {
                document.getElementById('checkboxError').textContent =
                    'Please read and agree to the Terms and Privacy.';
            }
        });
        $('#address-text').text(function(_, text) {
            return text.replace(/\s+,/g, ',');
        });
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/emission-modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/image-preview.js') }}"></script>
@endsection
