@extends('admin.layouts.app')
@section('title')
    View Customer
@endsection
@section('content')
@if (!adminPermissionCheck('companystaff.index'))
    @php
        $display = 'style=display:none';
    @endphp
@else
    @php
        $display = '';
    @endphp
@endif
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customer</a></li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="table-header">
        <div class="row align-items-center" {{$display}}>
            <div class="col-12">
                <div class="dw-header">
                    <a class="createsheet-btn" href="{{ route('companystaff.index', $companyInfo->id) }}">
                        ViEW Staff List
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="w0" class="table table-bordered detail-view detail-view-table">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ !empty($companyInfo->user->name) ? $companyInfo->user->name : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>UserName</th>
                        <td>{{ !empty($companyInfo->user->username) ? $companyInfo->user->username : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td>{{ !empty($companyInfo->user->email) ? $companyInfo->user->email : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>User Role</th>
                        <td>{{ !empty($companyInfo->user->role) ? $companyInfo->user->role->role : 'N/A' }}</td>
                    </tr>
                    @if (isset($companyInfo->user->status))
                        @if ($companyInfo->user->status == '1')
                            @php
                                $badgename = 'Active';
                                $badge = 'status complet';
                            @endphp
                        @elseif($companyInfo->user->status == '0')
                            @php
                                $badgename = 'In Active';
                                $badge = 'status faile';
                            @endphp
                        @else
                            @php
                                $badgename = 'N/A';
                                $badge = 'status draft';
                            @endphp
                        @endif
                    @else
                        @php
                            $badgename = 'N/A';
                            $badge = 'status draft';
                        @endphp
                    @endif
                    <tr>
                        <th>Status</th>
                        <td><span class="info-detail {{ $badge }}">{{ $badgename }}</span></td>
                    </tr>
                    <tr>
                        <th colspan=2 style="text-align: center;">Company Details</th>
                    </tr>
                    <tr>
                        <th>Logo</th>
                        <td>
                            @if ($companyInfo instanceof \App\Models\Company && !empty($companyInfo->company_logo))
                                <img src="{{ $companyInfo->company_logo }}" class="preview-customer-profile imagepop"
                                    style="max-width:123px; max-height:123px;" title="company-logo-icon" alt="company-logo">
                            @else
                                <img src="{{ asset('/assets/images') . '/profile.png' }}" class="preview-customer-profile "
                                    style="max-width:123px; max-height:123px;" title="company-logo-icon" alt="company-logo">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Company Name</th>
                        <td>{{ !empty($companyInfo->company_name) ? $companyInfo->company_name : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Company Email</th>
                        <td>{{ !empty($companyInfo->company_email) ? $companyInfo->company_email : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Contact Number</th>
                        <td>{{ !empty($companyInfo->company_phone) ? $companyInfo->company_phone : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Company Account Id</th>
                        <td>{{ !empty($companyInfo->company_account_id) ? $companyInfo->company_account_id : 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Trade License Number</th>
                        <td>{{ !empty($companyInfo->trade_licence_number) ? $companyInfo->trade_licence_number : 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>No.of Employes</th>
                        <td>{{ !empty($companyInfo->no_of_employees) ? $companyInfo->no_of_employees : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ !empty($companyInfo->companyaddressesone->address) ? $companyInfo->companyaddressesone->address : 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td>{{ !empty($companyInfo->companyaddressesone->countries->name) ? $companyInfo->companyaddressesone->countries->name : 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td>{{ !empty($companyInfo->companyaddressesone->city) ? $companyInfo->companyaddressesone->city : 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Industry</th>
                        <td>{{ !empty($companyInfo->industry->name) ? $companyInfo->industry->name : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th colspan=2 style="text-align: center;">Emission Type</th>
                    </tr>
                    <tr>
                        <th>SCOPE 1</th>
                        <td>
                            @if (count($scopeOne) > 0)
                                @foreach ($scopeOne as $index => $value)
                                    @if ($value == 'Flight and Accommodation' || $value == 'Home Office')
                                        {{ $value }}
                                        {{ $index < count($scopeOne) - 1 ? ',' : '' }}
                                    @else
                                        <a href="javascript:void(0);" onclick="emissionModal(this)"
                                            data-slug="{{ generateSlug($value) }}" data-name="{{ $value }}">
                                            {{ $value }}
                                            {{ $index < count($scopeOne) - 1 ? ',' : '' }}
                                        </a>
                                    @endif
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>SCOPE 2</th>
                        <td>
                            @if (count($scopeTwo) > 0)
                                @foreach ($scopeTwo as $index => $value)
                                    @if ($value == 'Flight and Accommodation' || $value == 'Home Office')
                                        {{ $value }}
                                        {{ $index < count($scopeTwo) - 1 ? ',' : '' }}
                                    @else
                                        <a href="javascript:void(0);" onclick="emissionModal(this)"
                                            data-slug="{{ generateSlug($value) }}" data-name="{{ $value }}">
                                            {{ $value }}
                                            {{ $index < count($scopeTwo) - 1 ? ',' : '' }}
                                        </a>
                                    @endif
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>SCOPE 3</th>
                        <td>
                            @if (count($scopeThree) > 0)
                                @foreach ($scopeThree as $index => $value)
                                    @if ($value == 'Flight and Accommodation' || $value == 'Home Office')
                                        {{ $value }}
                                        {{ $index < count($scopeThree) - 1 ? ',' : '' }}
                                    @else
                                        <a href="javascript:void(0);" onclick="emissionModal(this)"
                                            data-slug="{{ generateSlug($value) }}" data-name="{{ $value }}">
                                            {{ $value }}
                                            {{ $index < count($scopeThree) - 1 ? ',' : '' }}
                                        </a>
                                    @endif
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    @if (!empty($companyDocument) && count($companyDocument) > 0)
                        @php
                            $tradelicense = [];
                            $establishment = [];
                            foreach ($companyDocument as $document) {
                                $explodeurl = explode('company_admin/', $document['file_name']);
                                if ($document['document_type'] == 'Trade License') {
                                    $tradelicense[] = $document['file_name'];
                                } else {
                                    $establishment[] = $document['file_name'];
                                }
                            }
                        @endphp
                        <tr>
                            <th colspan=2 style="text-align: center;">KYC Document</th>
                        </tr>
                        <tr>
                            <th>Trade License</th>
                            <td>
                                @if (!empty($tradelicense))
                                    <ul class="cd-doc-list">
                                        @foreach ($tradelicense as $value)
                                            @php
                                                $fileExtension = pathinfo($value, PATHINFO_EXTENSION);
                                            @endphp
                                            <li class="cd-doc-item">
                                                @if($fileExtension == 'pdf')
                                                    <a target="_blank" href="{{ $value }}">
                                                @endif
                                                    <span class="file-icon">
                                                        <picture>
                                                            <img src="{{$fileExtension === 'pdf' ? asset('assets/images/pdf.png') : $value}}"
                                                            class="{{ $fileExtension != 'pdf' ? 'imagepop' : '' }}" style="width:50px; height:50px;" alt="file-icon" title="file">
                                                        </picture>
                                                    </span>
                                                @if($fileExtension == 'pdf')
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Establishment</th>
                            <td>
                                @if (!empty($establishment))
                                    @foreach ($establishment as $value)
                                    @php
                                        $fileExtension = pathinfo($value, PATHINFO_EXTENSION);
                                    @endphp
                                    @if($fileExtension == 'pdf')
                                        <a target="_blank" href="{{ $value }}">
                                    @endif
                                        <span class="file-icon">
                                            <picture>
                                                <img src="{{$fileExtension === 'pdf' ? asset('assets/images/pdf.png') : $value}}" alt="file-icon"
                                                class="{{ $fileExtension != 'pdf' ? 'imagepop' : '' }}" style="width:50px; height:50px;" title="file">
                                            </picture>
                                        </span>
                                    @if($fileExtension == 'pdf')
                                        </a>
                                    @endif
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>Total Sheet Uploaded</th>
                        <td>{{ !empty($datsheetCount) ? $datsheetCount : 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @include('common-modal.emission-modal')
    <div class="row align-items-center mt-3">
        <div class="col-md-6 col-12">
            <h2 class="section-title">View Plan History</h2>
        </div>
        <div class="col-md-12 mt-4">
            <div class="row">
                <table id="subscription-history" class="table custome-datatable manage-customer-table display">
                    <thead>
                        <tr>
                            <th class="mw-170">UPDATED BY</th>
                            <th class="mw-170">SUBSCRIPTION START DATE</th>
                            <th class="mw-170">SUBSCRIPTION END DATE</th>
                            <th class="mw-170">SUBSCRIPTION CREATE DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        const emissionRoute = "{{ route('customer.emission-data') }}"
        const companyId = "{{ $companyInfo->id }}"
        $(document).ready(function() {
            var table = $("#subscription-history").DataTable({
                processing: true,
                serverSide: true,
                language: {
                    searchPlaceholder: "Search"
                },
                "initComplete": function(settings, json) {
                    $("#subscription-history").wrap(
                        "<div class='table-view-activity subscription-history-wrap'></div>");
                },
                ajax:{
                    url: "{{ route('customer.show', Request()->id) }}",
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        } 
                    },
                }, 
                order: [
                    [3, 'desc']
                ],
                columns: [

                    {
                        data: 'user.name',
                        name: 'user.name',
                        orderable: false,
                        searchable: true,
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: true,
                    },
                ],
                columnDefs: [{
                    targets: '_all',
                    defaultContent: '-'
                }, ],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#subscription-history_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon" title="back">');
                    $("#subscription-history_next").html(
                        '<img src="{{ asset('assets/images/arrow-next.svg') }}" alt="next-icon" title="next">');
                    var pageInfo = table.page.info();
                    var currentPage = pageInfo.page + 1;
                    if (currentPage == 1 && recordsTotal  <= 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                }
            });
        })

        function emissionModal(input) {
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            $.ajax({
                url: emissionRoute,
                type: 'post',
                data: {
                    'name': $(input).data('name'),
                    'slug': $(input).data('slug'),
                    'company_id': companyId,
                    '_token': CSRF_TOKEN
                },
                success: function(response) {
                    $("#emission-modal").modal('show');
                    $("#emission-title").text($(input).data('name'));
                    const ulBody = document.querySelector('.ul-body');
                    let li = '';

                    const processVehicleType = (vehicleType, title) => {
                        if (response[vehicleType]) {
                            li += `<li class="em-title">${title}</li>`;
                            li += response[vehicleType].map(item => `<li>${item}</li>`).join(
                                '');
                        }
                    };

                    const inputName = $(input).data('name');

                    if (inputName === 'Owned vehicles' || inputName === 'Freighting goods' |
                        inputName === 'Flight and Accommodation') {
                        if (inputName === 'Owned vehicles') {
                            processVehicleType('passengerVehicle', 'Passenger vehicles');
                            processVehicleType('deliveryVehicle', 'Delivery vehicles');
                        } else if (inputName === 'Flight and Accommodation') {
                            processVehicleType('flights', 'Flights');
                            processVehicleType('hotels', 'Hotels');
                        } else {
                            processVehicleType('vansHgsData', 'Vans and HGVs');
                            processVehicleType('flightRailData',
                                'Flights, rail, sea tanker and cargo ship');
                        }
                    } else {
                        li = response.map(item => `<li>${item}</li>`).join('');
                    }

                    ulBody.innerHTML = li;
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        button.prop('disabled', false);
                        button.html('UPDATE');
                        companyIndustryError(xhr.responseJSON.errors);
                    }
                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    } 
                }
            });
        }
    </script>
@endsection
