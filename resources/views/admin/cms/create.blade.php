@extends('admin.layouts.app')

@section('title')
@if(isset($cms))
Edit CMS
@else 
Create CMS
@endif
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cms.index') }}">CMS Management</a></li>
    @if(isset($cms))
    <li class="breadcrumb-item active">Edit</li>
    @else
    <li class="breadcrumb-item active">Create</li>
    @endif
</ul>
    <div class="customer-support">
      @if(isset($cms))
    <form action="{{ route('cms.update', $cms->id) }}" enctype="multipart/form-data" method="post" class="input-form">
    @csrf
    @else
    <form action="{{ route('cms.store') }}" enctype="multipart/form-data" method="post" class="input-form">
    @csrf
    @endif
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" value="@if(isset($cms)){{ $cms->slug }}@else{{ old('slug') }}@endif" placeholder="slug" 
                    class="form-controal" @if(isset($cms)) readonly @endif maxlength="20">
                    @error('slug')
                    <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" value="@if(isset($cms)){{ $cms->title }}@else{{ old('title') }}@endif" placeholder="Title" 
                    class="form-controal" maxlength="20">
                    @error('title')
                    <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

				<div class="col-md-4 col-sm-6 col-12">
					<div class="form-group">
						 <label for="status">Status</label>
						 <select name="status" id="status">
							  <option value="1" {{ (old('status') == '1' || (isset($cms) && $cms->status == '1')) ? 'selected' : '' }}>Active</option>
							  <option value="0" {{ (old('status') == '0' || (isset($cms) && $cms->status == '0')) ? 'selected' : '' }}>Inactive</option>
						 </select>
					</div>
			  </div>
			  
			  

            <div class="col-md-12 col-12">
                <div class="form-group">
                    <label>Content</label>
                    <textarea class="form-control"
                        id="tinymce" name="content">@if(isset($cms)){{ $cms->content }}@else{{ old('content') }}@endif</textarea>
                    @error('content')
                    <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{route('cms.index')}}" class="back-btn">Cancel</a>
                    <button type="submit" title="submit" class="btn-primary" href="">Submit</button>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection
@section('footer_scripts')
{{-- <script type="text/javascript" src="https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/5-stable/tinymce.min.js"></script> --}}

<script type="text/javascript">
  
		tinymce.init({
		  selector: '#tinymce',
		  height: 430,
		  toolbar_mode:"wrap",
		  forced_root_block: false,
		  plugins: ["code image emoticons advlist charmap directionality  lists  link insertdatetime nonbreaking pagebreak preview print searchreplace table wordcount","searchreplace visualblocks code fullscreen","insertdatetime media  table contextmenu paste"],
		  toolbar: "undo redo code fontselect fontsizeselect  bold italic underline strikethrough   superscript subscript  alignleft aligncenter alignright alignjustify alignnone  indent outdent  bullist numlist  charmap table emoticons image fullscreen",
		//   toolbar1: "undo redo code fontselect fontsizeselect  bold italic underline strikethrough   superscript subscript  alignleft aligncenter alignright alignjustify alignnone  indent outdent  bullist numlist  charmap table emoticons image fullscreen",
		  branding: false,
		  mobile: {
				menubar: true,
				toolbar_mode:"wrap",
				height: 650,
			},
		  setup : function(ed) {
			ed.on('keyup', function(e) {
				var edData = tinyMCE.get('onlineTeditor').getContent();
				localStorage.setItem('editorData', edData);
			});
			ed.on('init', function(e) {
				setTimeout(() => {
					$(".tox-toolbar__group button,.tox-split-button").css({"background": "white", "margin": "8px 9px"});
					$(".tox-toolbar__group button,.tox-split-button").addClass("tinymec_buttons_bg");
					$(".tox-editor-header,.tox-toolbar,.tox-edit-area__iframe").addClass("tinymecdark_bg_n");
					$(".tox-menubar").addClass("tinymecdark_menubar_bg");
					$(".tox-menubar button,.tox-toolbar button,.mce-content-body").addClass("tinymecdark_color");
					$("#onlineTeditor_ifr").contents().find(".mce-content-body").addClass("tinymecdark_color");

					if ( $('#dark_theme').length === 0 ) {
						$("#onlineTeditor_ifr").contents().find(".mce-content-body").css({"color": "black"});
					} else {
						$("#onlineTeditor_ifr").contents().find(".mce-content-body").css({"color": "white"});
					}
					var savedData = localStorage.getItem("editorData");;
					if(savedData) {
						tinymce.get("onlineTeditor").setContent(savedData);
					}
				}, 10);
			});

		  }		  
		  
		});
		$(document).ready(function () {
			$(".switch").on("click", function(){
				if ( $('#dark_theme').length === 0 ) {
					$("#onlineTeditor_ifr").contents().find(".mce-content-body").css({"color": "black"});
				} else {
					$("#onlineTeditor_ifr").contents().find(".mce-content-body").css({"color": "white"});
				}
			});
		});
		function download_documnet(){
			text = tinyMCE.get('onlineTeditor').getContent();
			let token = $("#g-recaptcha-response").val();
			grecaptcha.reset();
			if(!text.trim()) {
				show_messages('error',"No Text To Download.");
				return false;
			}
			showLoader(true);
			$.ajax({
				type:'post',
				data:{text,'g-recaptcha-response':token},
				dataType: 'json',
				url:base_url+'download-text-editor-pdf/',
				success: function(response) {
					var url = response.link;
					filename = "online-text-editor-pdf.pdf";
					if(url !==null){
						fetch(url).then(function(t) {
							return t.blob().then((b)=>{
								var a = document.createElement("a");
								a.href = URL.createObjectURL(b);
								a.setAttribute("download", filename);
								a.click();
							});
						});
					}
					showLoader(false);
				},
				error: function (xhr, textStatus, errorThrown){
					showLoader(false);
					show_messages("Sorry Something Went Wrong");
                    // Handle the HTTP status code here
                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    } 
				}
			}); 
		}
		function download_report() {
			$("#btn_download_documnet").trigger('click');
		}
		// internal linking
		$('.txtEdtr_Internal_linking').click(function(e){
			e.preventDefault();
			var submission_value= tinyMCE.get('onlineTeditor').getContent({ format: 'text' });
			//remove extra spaces
			// submission_value = submission_value.replace(/\s+/g, ' ').trim();
			$('#internal_linking_text').val(submission_value);

			if(e.target.id == "plg_chkr"){
				$('#internal_linking_text').attr('name','plagiarism_text');
				$('#internal_linking_form').attr('action','https://smallseotools.com/plagiarism-checker/');
			}else if(e.target.id == "gramr_chkr"){
				$('#internal_linking_text').attr('name','grammar_text');
				$('#internal_linking_form').attr('action','https://smallseotools.com/grammar-checker/');
			}
			else if(e.target.id == "praphrse_tool"){
				$('#internal_linking_text').attr('name','paraphrase_text');
				$('#internal_linking_form').attr('action','https://smallseotools.com/paraphrasing-tool/');
			}
			$('#internal_linking_form').submit();
		});
	</script>

@endsection
