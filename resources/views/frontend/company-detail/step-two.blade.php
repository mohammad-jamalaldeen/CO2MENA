@extends('frontend.layouts.app')
@section('title')
    Company Details
@endsection
@section('content')
    <div class="company-documents">
        <div class="bg-main">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <h2 class="section-title">Company Documents</h2>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="link">
                        <a href="javascript:void(0)" title="Save as draft">Save as draft</a>
                    </div>
                </div>
            </div>
            <form class="input-form" method="post" id="step-two-form" novalidate=""
                action="{{ route('company-detail-step-two.create') }}" enctype="multipart/form-data">
                @csrf()
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="trade_license">TRADE LICENSE <span class="mandatory-field">*</span></label>
                            <div class="row">
                                <div class="col-12 ">
                                    <span class="upload-btn  trade-license-class" >Select TRADE LICENSE</span>
                                    <input type="file" class="file-border" name="trade_license[]"
                                        onchange="tradeLicenseNameSet(this)" id="trade_license" multiple
                                        accept=".pdf, .doc, .docx, image/*">
                                        <span class="error-note">Accepted File Types: jpeg, png, jpg, webp, doc, docx and pdf file.</span>
                                </div>
                                <div class="trade-license-class-preview">
                                    @if (count($companyDocumentData) > 0)
                                        @foreach ($companyDocumentData as $value)
                                            @if ($value['document_type'] == \App\Models\CompanyDocument::TRADE_LICENSE && $value['file_name'])
                                                @php
                                                    $fileExtension = pathinfo($value['file_name'], PATHINFO_EXTENSION);
                                                    if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                    {
                                                        $trandLicenseFile = ($fileExtension === 'pdf') ? asset('assets/images/pdf.png') : asset('assets/images/doc.png');
                                                    } else {
                                                        $trandLicenseFile = $value['file_name'];
                                                    }
                                                @endphp
                                                @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                    <a href="{{ $value['file_name'] }}" target="_blank" title="TRADE LICENSE">
                                                @endif
                                                <img alt="tradeLicense-file" src="{{ $trandLicenseFile }}"
                                                    height="20px" width="20px"
                                                    class="{{ ($fileExtension != 'pdf' || $fileExtension != 'doc' || $fileExtension != 'docx')? 'imagepop' : '' }}">
                                                @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="establishment">ESTABLISHMENT CARD</label>
                            <div class="row">
                                <div class="col-12 ">
                                    <span class="upload-btn  establishment-class">Select ESTABLISHMENT CARD
                                        Card</span>
                                    <input type="file" class="file-border" name="establishment[]"
                                        onchange="establishmentNameSet(this)" id="establishment" multiple
                                        accept=".pdf, .doc, .docx, image/*">
                                        <span class="error-note">Accepted File Types: jpeg, png, jpg, webp, doc, docx and pdf file.</span>
                                </div>
                                <div class="establishment-class-preview">
                                    @if (count($companyDocumentData) > 0)
                                        @foreach ($companyDocumentData as $value)
                                            @if ($value['document_type'] == \App\Models\CompanyDocument::ESTABLISHMENT && $value['file_name'])
                                                @php
                                                    $fileExtension = pathinfo($value['file_name'], PATHINFO_EXTENSION);
                                                    if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                    {
                                                        $trandLicenseFile = ($fileExtension === 'pdf') ? asset('assets/images/pdf.png') : asset('assets/images/doc.png');
                                                    } else {
                                                        $trandLicenseFile = $value['file_name'] ;
                                                    }
                                                @endphp
                                                @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                    <a href="{{ $value['file_name'] }}" target="_blank" title="ESTABLISHMENT">
                                                @endif
                                                <img alt="establishment" src="{{ $trandLicenseFile }}"
                                                    height="20px" width="20px" class="{{  ($fileExtension != 'pdf' || $fileExtension != 'doc' || $fileExtension != 'docx' ) ? 'imagepop' : '' }}">
                                                @if ($fileExtension === 'pdf' || $fileExtension === 'doc' || $fileExtension === 'docx')
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="savedraft" id="savedraft" value="continue">
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="btn-wrap">
                            <div class="button-row previous">
                                <a class="btn-primary" href="{{ route('company-detail-step-one.index') }}" title="PREVIOUS">
                                    <picture>
                                        <img src="{{ asset('assets/images/Arrow-left.svg') }}" alt="button-arrow" width="24"
                                            height="24">
                                    </picture>
                                    PREVIOUS
                                </a>
                            </div>
                            <div class="button-row continue">
                                <button type="submit" class="btn-primary" id="step-two-continue" title="continue">CONTINUE
                                    <picture>
                                        <img src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow"
                                            width="24" height="24">
                                    </picture>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('common-modal.image-preview-modal')
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest(
        \App\Http\Requests\Frontend\CreateCompanyDetailStepTwoRequest::class,
        '#step-two-form',
    ) !!}
    <script type="text/javascript">
        async function setPlaceholder(input, className) {
            var placeholderImageName = '';
            var breakFlag = false;
            var customClass = (className === 'trade-license-class') ? 'trade-license-remove-class' : (className === 'establishment-class' ? 'establishment-remove-class' : '') 

            if (className === 'trade-license-class' || className === 'establishment-class') {
                var previewSelector = '.' + className + '-preview';
                const allowedSizeInKB = 15360; // 15MB in kilobytes
                const allowedTypes = new Set(['application/pdf', 'image/png',
                    'image/jpeg','image/jpg','application/msword', // DOC
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // DOCX
                ]);
                const files = input.files;
                const exceedsSizeLimit = [...files].some(file => (file.size / 1024) > allowedSizeInKB);
                if (exceedsSizeLimit) {
                    setReturnMsg("danger", 'Please upload a file with a maximum size of 15 MB.');
                    breakFlag = true;
                    return;
                }

                if ([...files].some(file => !allowedTypes.has(file.type))) {
                    return;
                }

                $('.' + customClass).remove()
                for (var i = 0; i < input.files.length; i++) {
                    if (input.files[i]) {
                        // if (input.files[i].size > 15 * 1024 * 1024) {
                        //     setReturnMsg("danger", 'Please upload a file with a maximum size of 15 MB.');
                        //     breakFlag = true;
                        //     break;
                        // }

                        if (input.files[i].type === 'application/pdf' || input.files[i].type === 'application/msword' || input.files[i].type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                            // If it's a PDF file, make an async request to get the PDF image
                            try {
                                const response = (input.files[i].type === 'application/pdf') ?  await fetch("{{ asset('assets/images/pdf.png') }}") : await fetch("{{ asset('assets/images/doc.png') }}");
                                if (response.ok) {
                                    const imageBlob = await response.blob();
                                    const imageUrl = URL.createObjectURL(imageBlob);
                                    const imagePreview =
                                        `<img alt="img" src="${imageUrl}" height="20px" width="20px" class="attachment-image ${customClass}">`;
                                    // Update the preview here to ensure the image is added after loading
                                    $(previewSelector).append(imagePreview);
                                } else {
                                    setReturnMsg("danger", 'Failed to fetch PDF or doc image');
                                }
                            } catch (error) {
                                console.error('Error fetching PDF image:', error);
                            }
                        } else if (input.files[i].type === 'image/png' || input.files[i].type === 'image/jpg' || input
                            .files[i].type === 'image/webp' || input
                            .files[i].type === 'image/jpeg') {
                            let reader = new FileReader();
                            reader.onload = function(event) {
                                const imagePreview = '<img alt="img" src="' + event.target.result +
                                    '" height="20px" width="20px" class="attachment-image imagepop '+customClass+'">';
                                // Update the preview here to ensure the image is added after loading
                                $(previewSelector).append(imagePreview);
                            };
                            reader.readAsDataURL(input.files[i]);
                        }
                    }

                    placeholderImageName += input.files[i].name;
                    if (i < input.files.length - 1) {
                        placeholderImageName += ', ';
                    }
                }

                if (!breakFlag) {
                    $('.' + className).text(placeholderImageName);
                } else {
                    $(input).val(null);
                }
            }
        }

        function tradeLicenseNameSet(input) {
            setPlaceholder(input, 'trade-license-class');
        }

        function establishmentNameSet(input) {
            setPlaceholder(input, 'establishment-class');
        }

        $('.link').click(function() {
            $('#savedraft').val('savedraft');
            $('#step-two-continue').trigger('click');
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
    <script type="text/javascript" src="{{ asset('assets/js/image-preview.js') }}"></script>
@endsection
