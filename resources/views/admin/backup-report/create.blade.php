@extends('admin.layouts.app')
@section('title')
Create Backup Reports
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('backup-report.index') }}">Backup Reports</a></li>
        <li class="breadcrumb-item active">CREATE</li>
    </ul>
    <div class="customer-support">
        <form action="{{ route('backup-report.store') }}" enctype="multipart/form-data" method="post" class="input-form">
            @csrf
            <div class="row">
                <div class="col-12">
                    @if(old('radiocheck') == "custom")
                        @php $checked="checked";@endphp
                    @else
                        @php $checked="";@endphp
                    @endif
                    <div class="form-group">
                        <div class="radio-wrapper backup-reports-radio-group">
                            <label class="radio-btn">
                                <input type="radio" name="radiocheck" value="all" id="allcheck" checked>All<span class="checkmark"></span>
                            </label>
                            <label class="radio-btn">
                                <input type="radio" name="radiocheck" id="customcheck" value="custom" {{$checked}}>Custom <span class="checkmark"></span>
                            </label>
                        </div>
                        @error('radiocheck')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="company">Company <span class="mandatory-field">*</span></label>
                        <select name="company" id="company" placeholder="Select Company">
                            @if(!empty($companies))
                            @foreach ($companies as $company)
                                <option value="{{$company['id']}}" {{old('company') == $company['id'] ? "selected":""}}>{{$company['company_name']}}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('company')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                              
                <div class="col-md-4 col-12 customcheckrow  {{ (old('radiocheck') == "custom")  ? 'd-block' : 'd-none' }}">
                    <div class="form-group">
                        <label>Custom Date <span class="mandatory-field">*</span></label>
                        <input type="text" name="custom_date" value="{{old('custom_date')}}" class="form-controal float-right" id="start_end_date" placeholder="Select Start & End Date" autocomplete="off" readonly>
                        <input type="hidden" name="my_hidden_startdate" id="my_hidden_startdate" value="{{old('my_hidden_startdate')}}">
                        <input type="hidden" name="my_hidden_enddate" id="my_hidden_enddate" value="{{old('my_hidden_enddate')}}">
                        @error('custom_date')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="towbutton-row">
                        <a href="{{ route('backup-report.index') }}" class="back-btn" title="cancel">Cancel</a>
                        <button type="submit" title="submit" class="btn-primary" href="">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer_scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $("input[type='radio']").change(function(){
        if($(this).is(":checked")){
            var value = $(this).val();
            if(value == "custom"){
                $(".customcheckrow").addClass("d-block");
                $(".customcheckrow").removeClass("d-none");
            }else{
                $(".customcheckrow").addClass("d-none");
                $(".customcheckrow").removeClass("d-block");
            }
        }else{
            $(".customcheckrow").addClass("d-none");
            $(".customcheckrow").removeClass("d-block");
        }
    });
    $('input[name="custom_date"]').daterangepicker({
        autoUpdateInput: false,
        opens: 'left',
        minYear: 2021,
    }, function(start, end, label) {
        var start_date = start.format('YYYY-MM-DD');
        $('#my_hidden_startdate').val(start_date).append();
        var end_date = end.format('YYYY-MM-DD');
        $('#my_hidden_enddate').val(end_date).append();
        $("#start_end_date").val(start_date +' - '+end_date);
    });
</script>
@endsection