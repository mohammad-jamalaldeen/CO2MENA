@extends('frontend.layouts.app')
@section('title')
    Company Details
@endsection
@section('content')
<style>
    .error-msg{color: #d32828;}
</style>
    <section class="company-details">
        <div class="container-fluid">
            <div class="bg-main">
                <form method="post" name="" id="step-four-form" novalidate=""
                    action="{{ route('company-detail-step-four.create') }}">
                    @csrf()
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <h2 class="section-title">Company Details</h2>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="link">
                                <a href="javascript:void(0)" title="Save as draft">Save as draft</a>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            @include('frontend.company-detail.activity-tab')
                        </div>
                        <input type="hidden" name="company_id" value="{{ $companyData->id }}">
                        <input type="hidden" name="user_id" value="{{ $companyData->user_id }}">
                        <input type="hidden" name="total_activity"
                            value="{{ count($companyData->companyactivities) }}">
                        <input type="hidden" name="savedraft" id="savedraft" value="continue">
                    </div>
                    <div class="row row-button">
                        <div class="col-12">
                            <div class="btn-wrap">
                                <div class="button-row previous">
                                    <a class="btn-primary" href="{{ route('company-detail-step-three.index') }}" title="PREVIOUS">
                                        <picture>
                                            <img src="{{ asset('assets/images/Arrow-left.svg') }}" alt="button-arrow"
                                                width="24" height="24">
                                        </picture>
                                        PREVIOUS
                                    </a>
                                </div>
                                <div class="button-row continue">
                                    <button type="submit" class="btn-primary" id="step-four-continue" title="continue">CONTINUE
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
    </section>
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        // $(document).ready(function() {
        //     $("#pills-tab li:first").find("button").addClass('active');
        //     function handleCheckboxChange(checkboxClass, selectAllCheckboxId, checkCount) {
        //         var checkboxes = $('.' + checkboxClass);
        //         var selectAllCheckbox = $('#' + selectAllCheckboxId);
        //         checkboxes.change(function() {
        //             var totalCheckboxes = checkboxes.length;
        //             selectAllCheckbox.prop('checked', totalCheckboxes === checkedCheckboxes);
        //         });

        //         selectAllCheckbox.change(function() {
        //             var isChecked = $(this).prop('checked');
        //             checkboxes.prop('checked', isChecked);
        //         });
            
        //         if (checkCount == 0) {
        //             //checkboxes.prop('checked', true);
        //             selectAllCheckbox.prop('checked', checkboxes.length === checkboxes.filter(':checked').length);
        //             return false;
        //         } else {
        //             selectAllCheckbox.prop('checked', checkboxes.length === checkboxes.filter(':checked').length);
        //         }
        //     }
        //     $(".activities-data").each(function() {
        //         var allcheck = $(this).data('allcheck');
        //         var checkbox = $(this).data('checkbox');
        //         handleCheckboxChange(checkbox,allcheck,$(this).val());
        //     });
        // });
        $(document).ready(function() {
    function handleCheckboxChange(checkboxClass, selectAllCheckboxId, checkCount) {
        var checkboxes = $('.' + checkboxClass);
        var selectAllCheckbox = $('#' + selectAllCheckboxId);
        
        checkboxes.change(function() {
            var totalCheckboxes = checkboxes.length;
            var checkedCheckboxes = checkboxes.filter(':checked').length; // Added this line
            selectAllCheckbox.prop('checked', totalCheckboxes === checkedCheckboxes);
        });

        selectAllCheckbox.change(function() {
            var isChecked = $(this).prop('checked');
            checkboxes.prop('checked', isChecked);
        });

        if (checkCount == 0) {
            //checkboxes.prop('checked', true);
            selectAllCheckbox.prop('checked', checkboxes.length === checkboxes.filter(':checked').length);
            return false;
        } else {
            selectAllCheckbox.prop('checked', checkboxes.length === checkboxes.filter(':checked').length);
        }
    }
    
    $(".activities-data").each(function() {
        var allcheck = $(this).data('allcheck');
        var checkbox = $(this).data('checkbox');
        handleCheckboxChange(checkbox, allcheck, $(this).val());
    });
});


        $('.link').click(function() {
            $('#savedraft').val('savedraft');
            $('#step-four-continue').trigger('click');
        });
    </script>
@endsection
