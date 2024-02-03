@extends('frontend.layouts.main')
@section('title')
    Customer Support
@endsection
@section('content')
    <div class="customer-support">
        <form action="{{ route('customer-support.create') }}" enctype="multipart/form-data" novalidate=""
            id="customer-support-form" method="post" class="input-form">
            @csrf
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="name">NAME <span class="mandatory-field">*</span></label>
                        <input type="text" name="name" id="name" value="{{ $userDetail->name }}" placeholder="Enter name"
                            class="form-controal"  autocomplete="off" >
                        @error('name')
                        <span class="error-mgs">
                            <strong> {{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="email">EMAIL ADDRESS <span class="mandatory-field">*</span></label>
                        <input type="email" name="email" id="email" value="{{ $userDetail->email }}" placeholder="Enter email"
                            class="form-controal" autocomplete="off" >
                        @error('email')
                        <span class="error-mgs">
                            <strong> {{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                    <?php 
                    if(in_array($userDetail->user_role_id, ['7','8','9']) ){
                        $phone = $userDetail->contact_number; 
                    }else{
                        $phone = $userDetail->company->company_phone;
                    
                   } ?>
                        <label for="phone_number">CONTACT NUMBER <span class="mandatory-field">*</span></label>
                        <input type="text" name="phone_number" id="phone_number" maxlength="15"
                            placeholder="Enter contact number" class="form-controal" value={{$phone}}>
                            @error('phone_number')
                            <span class="error-mgs">
                                <strong> {{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                </div>
                <div class="col-sm-8 col-12">
                    <div class="form-group custome-input-group errorDatasheetFileCls">
                        <label for="filename">UPLOAD ATTACHMENTS</label>
                        <span class="upload-btn  trade-license-class" id="upload-btn">Files</span>
                        <input type="file" id="filename" name="filename[]" class="file-border"
                            onchange="supportFilePreview(this)" 
                            multiple
                            accept=".jpg, .jpeg, .png, .mp4, .avi, .pdf, .doc, .docx,.zip,.rar"/>
                            <span class="error-note">Accepted File Types: jpg,jpeg,png,xlsx,pdf,doc file.</span>
                    </div>
                </div>
                <div class="col-sm-4 col-12" id="display_attchments">
                    <div class="form-group">
                        <label for="filename">DISPLAY ATTACHMENTS</label>
                        <ul class="attachment">
                            <li>
                                <picture>
                                    <img src="{{ asset('assets/images/file-img.png') }}" alt="file icon" width="38"
                                        height="46">
                                </picture>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group select-error">
                        <label for="subject">Subject <span class="mandatory-field">*</span></label>
                          <input type="text" name="subject" id="subject" maxlength="14"
                            placeholder="Enter subject" class="form-controal">
                        {{-- <select class="" name="subject" id="subject" title="Select subject">
                            @foreach (\App\Models\CustomerSupport::SUBJECT as $value)
                                <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select> --}}
                        @error('subject')
                        <span class="error-mgs">
                            <strong> {{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="message">MESSAGE <span class="mandatory-field">*</span></label>
                        <textarea name="message" id="message" oninput="charLengthValidation(this, 10000)" placeholder="Enter message"
                            class="form-controal" rows="4"></textarea>
                            @error('message')
                            <span class="error-mgs">
                                <strong> {{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="towbutton-row">
                        <button type="submit" class="btn-primary" title="send-message">SEND MESSAGE</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        async function readImage(file) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = (event) => resolve(event.target.result);
                reader.readAsDataURL(file);
            });
        }

        async function supportFilePreview(input) {
            try {
                const allowedExtensions = new Set(['jpeg', 'jpg','png', 'webp', 'pdf', 'doc',
                    'docx','xlsx'
                ]);
                const files = input.files;

                if ([...files].some(file => !allowedExtensions.has(getFileExtension(file.name)))) {
                    setReturnMsg("danger", "Only Jpeg, jpg, png, webp, pdf, doc, docx, xlsx file type support .");
                    return;
                }
                

              const allowedSizeInKB = 15360; // 15MB in kilobytes
                const exceedsSizeLimit = [...files].some(file => (file.size / 1024) > allowedSizeInKB);
                if (exceedsSizeLimit) {
                    setReturnMsg("danger", "Please upload files less than 15 MB.");
                    $('#loader').css('display', 'none');
                    return;
                } 

                const attachment = $('.attachment');
                attachment.html('');
                const placeholderImageName = [];

                for (const file of files) {
                    const extension = getFileExtension(file.name);
                    let imageSrc = await getImageSrc(extension, file);
                    const imagePreview = createImagePreview(imageSrc);
                    attachment.append(imagePreview);
                    placeholderImageName.push(file.name);
                }

                $('#customersupportfilename').attr('placeholder', placeholderImageName.join(', '));
            } catch (error) {
                console.error('Error previewing files:', error);
            }
        }

        function getFileExtension(filename) {
            return filename.split('.').pop().toLowerCase();
        }

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

        async function getImageSrc(extension, file) {
            if (isPDF(extension)) {
                return "{{ asset('assets/images/pdf.png') }}";
            } else if (isVideo(extension)) {
                return "{{ asset('assets/images/video.png') }}";
            } else if (isDocument(extension)) {
                return "{{ asset('assets/images/doc.jpg') }}";
            } else if (isZip(extension)) {
                return "{{ asset('assets/images/file-img.png') }}";
            } else if (isExcel(extension)) {
                return "{{ asset('assets/images/excel.png') }}";
            } else {
                return await readImage(file);
            }
        }

        function createImagePreview(imageSrc) {
            return `<li>
                <picture>
                    <img src="${imageSrc}" alt="file icon" width="38" height="46">
                </picture>
            </li>`;
        }

        function getFileExtension(filename) {
            return filename.split('.').pop().toLowerCase();
        }

        function isImage(extension) {
            return ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(extension);
        }

        function isVideo(extension) {
            return ['mp4', 'avi', 'mov', 'mkv'].includes(extension);
        }

        function isDocument(extension) {
            return ['doc', 'docx'].includes(extension);
        }

        function isPDF(extension) {
            return extension === 'pdf';
        }
        function isZip(extension) {
            return ['zip','rar'].includes(extension);
        }

        function isExcel(extension) {
            return ['xlsx'].includes(extension);
        }

        function datasheetFileChange(input) {
            const maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
            const fileSize = input.files[0].size;
            $('#error-datasheet').remove();
            $('#errorDatasheetFile').remove();            
            if (fileSize > maxFileSize) {
                $('.errorDatasheetFileCls').after('<span class="error-mgs" id="error-datasheet">File size exceeds 5MB. Please choose a smaller file and re-upload.</span>')
                $('#filename').val('');
                $('#filename').text('Select a xlsx file to upload');
                return;
            }
        }
    </script>
    {{-- <script type="text/javascript" src="{{ asset('assets/js/contact-number-validation.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('assets/js/char-length-validation.js') }}"></script>
@endsection
