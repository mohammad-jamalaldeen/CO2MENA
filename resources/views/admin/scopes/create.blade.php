@extends('admin.layouts.app')

@section('title')
@php
$action = Route::getCurrentRoute()->getName();
if($action == "scopes.create"){
    $title = "Create Scope";
}else{
    $title = "Edit Scope";
}
@endphp
    {{$title}}
@endsection
@section('content')
    <div class="customer-support">
        <form class="input-form" id="scopes-create" method="POST" action="{{ route('scopes.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="industry">INDUSTRY</label>
                        <select name="industry" placeholder="please select" id="industry" value="{{ old('industry') }}" data-live-search="true">
                            <option value="" disabled>Select Industry</option>
                            @foreach ($companyIndustry as $industry)
                            @php
                                    if(!empty(Request()->id)){
                                        if($industry->id == Request()->id){
                                            $select = "selected";
                                        } else {
                                            $select = "";
                                        }
                                    } else {
                                        if(old('industry') == $industry->id){
                                            $select = "selected";    
                                        }else{
                                            $select = "";
                                        }
                                        
                                    } 
                            @endphp
                                <option value="{{ $industry->id }}"  {{$select}}>{{ $industry->name }}</option>
                            @endforeach
                        </select>
                        @error('industry')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="scope1">Scope1</label>
                        <select name="scope1[]" placeholder="please select" class="select2" id="scope1" multiple value="{{ old('scope1[]') }}" data-live-search="true">
                            @foreach ($emissionTypes as $value)
                                @php
                                    if(!empty($scope1Array)){
                                        $selected = "";
                                        if(in_array($value['id'],$scope1Array)){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        $disabledoption = "";
                                        $style = "";
                                        if(in_array($value['id'],$scope2Array)){
                                            $disabledoption = "disabled";
                                            $style = "style=background-color:#e5e5e5;";
                                        } elseif (in_array($value['id'],$scope3Array)){
                                            $disabledoption = "disabled";
                                            $style = "style=background-color:#e5e5e5;";
                                        } else {
                                            $disabledoption = "";
                                            $style = "";
                                        }
                                    }else{
                                        $selected = "";
                                        $disabledoption = "";
                                        $style = "";
                                    }
                                @endphp
                                <option value="{{ $value['id'] }}" {{$selected}} {{$disabledoption}} {{$style}}>{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                        @error('scope1')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="scope2">Scope2</label>
                        <select name="scope2[]" placeholder="please select" class="select2" id="scope2" {{ count($scope2Array) == 0 ? 'disabled' : '' }} multiple value="{{ old('scope2[]') }}" data-live-search="true">
                            @foreach ($emissionTypes as $value)
                                @php
                                $selected = "";
                                if(in_array($value['id'],$scope2Array)){
                                    $selected = "selected";
                                }else{
                                    $selected = "";
                                }
                                $disabledoption = "";
                                $style = "";
                                if(in_array($value['id'],$scope1Array)){
                                    $disabledoption = "disabled";
                                    $style = "style=background-color:#e5e5e5;";
                                } elseif (in_array($value['id'],$scope3Array)){
                                    $disabledoption = "disabled";
                                    $style = "style=background-color:#e5e5e5;";
                                } else {
                                    $disabledoption = "";
                                    $style = "";
                                }
                            @endphp
                        <option value="{{ $value['id'] }}" {{$selected}} {{$disabledoption}} {{$style}}>{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="scope3">Scope3</label>
                        <select name="scope3[]" placeholder="please select" class="select2" id="scope3" {{ count($scope3Array) == 0 ? 'disabled' : '' }} multiple value="{{ old('scope3[]') }}" data-live-search="true">
                            @foreach ($emissionTypes as $value)
                                @php
                                    $selected = "";
                                    if(in_array($value['id'],$scope3Array)){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    $disabledoption = "";
                                    $style = "";
                                    if(in_array($value['id'],$scope1Array)){
                                        $disabledoption = "disabled";
                                        $style = "style=background-color:#e5e5e5;";
                                    } elseif (in_array($value['id'],$scope2Array)){
                                        $disabledoption = "disabled";
                                        $style = "style=background-color:#e5e5e5;";
                                    } else {
                                        $disabledoption = "";
                                        $style = "";
                                    }
                                @endphp
                                <option value="{{ $value['id'] }}" {{$selected}} {{$disabledoption}} {{$style}}>{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="towbutton-row">
                        <a href="{{ route('scopes.index') }}" class="back-btn" title="cancel">Cancel</a>
                        <button type="submit" class="btn-primary" title="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        $("#scope1").change(function() {
            var value = $(this).val();
            var value2 = $("#scope2").val();
            var value3 = $("#scope3").val();
            var mergevalue = value.concat(value2);
            var mergervalue2 = value.concat(value3);
            $("#scope2").prop('disabled', false);
            var scopdropdown2 = $("#scope2");
            var scopdropdown3 = $("#scope3");
            var Options2 = scopdropdown2.find("option").map(function() {
                return $(this).val();
            }).get();
            var Options3 = scopdropdown3.find("option").map(function() {
                return $(this).val();
            }).get();

            $.each(Options2, function(key, val) {
                if ($.inArray(val, mergervalue2) !== -1) {
                    scopdropdown2.find('option[value="' + val + '"]').prop('disabled', true).css(
                        "background-color", "#e5e5e5");
                } else {
                    scopdropdown2.find('option[value="' + val + '"]').prop('disabled', false).css(
                        "background-color", "");
                }
            });
            $('#scope2').selectpicker('refresh');

            $.each(Options3, function(key, val) {
                if ($.inArray(val, mergevalue) !== -1) {
                    scopdropdown3.find('option[value="' + val + '"]').prop('disabled', true).css(
                        "background-color", "#e5e5e5");
                } else {
                    scopdropdown3.find('option[value="' + val + '"]').prop('disabled', false).css(
                        "background-color", "");
                }
            });
            $('#scope3').selectpicker('refresh');
            if (value === null || value.length === 0) {
                $("#scope2").prop('disabled', true);
                $("#scope2").find('option:selected').prop('selected', false);
                $('#scope2').selectpicker('refresh');
                $("#scope3").prop('disabled', true);
                $("#scope3").find('option:selected').prop('selected', false);
                $('#scope3').selectpicker('refresh');
                return false;
            }

        });
        /***************** Scope 2 dropdown enable scope3 dropdwon******************* */
        $("#scope2").change(function() {
            var value = $(this).val();
            var value1 = $("#scope1").val();
            var value3 = $("#scope3").val();
            var mergevalue = value.concat(value1);
            var mergevalue2 = value.concat(value3);
            $("#scope3").prop('disabled', false);
            var scopdropdown3 = $("#scope3");
            var scopdropdown1 = $("#scope1");
            var Options3 = scopdropdown3.find("option").map(function() {
                return $(this).val();
            }).get();

            var Options1 = scopdropdown1.find("option:not(:selected)").map(function() {
                if ($(this).val() != "") {
                    return $(this).val();
                }
            }).get();

            $.each(Options3, function(key, val) {
                if ($.inArray(val, mergevalue) !== -1) {
                    scopdropdown3.find('option[value="' + val + '"]').prop('disabled', true).css(
                        "background-color", "#e5e5e5");
                } else {
                    scopdropdown3.find('option[value="' + val + '"]').prop('disabled', false).css(
                        "background-color", "");
                }
            });
            $('#scope3').selectpicker('refresh');

            $.each(Options1, function(key, val) {
                if ($.inArray(val, mergevalue2) !== -1) {
                    scopdropdown1.find('option[value="' + val + '"]').prop('disabled', true).css(
                        "background-color", "#e5e5e5");
                } else {
                    scopdropdown1.find('option[value="' + val + '"]').prop('disabled', false).css(
                        "background-color", "");
                }
            });
            $('#scope1').selectpicker('refresh');

            /***********************if variable value empty scop3 dropdwon disabled ********************** */
            if (value === null || value.length === 0) {
                $("#scope3").prop('disabled', true);
                $("#scope3").find('option:selected').prop('selected', false);
                $('#scope3').selectpicker('refresh');
                return false;
            }
        });
        /***************** Scope 3 dropdown and dependency******************* */
        $("#scope3").change(function() {
            var value = $(this).val();
            var value1 = $("#scope1").val();
            var value2 = $("#scope2").val();
            var mergevalue = value.concat(value2);
            var mergevalue2 = value.concat(value1);
            var scopdropdown1 = $("#scope1");
            var scopdropdown2 = $("#scope2");

            var Options1 = scopdropdown1.find("option:not(:selected)").map(function() {
                if ($(this).val() != "") {
                    return $(this).val();
                }
            }).get();

            var Options2 = scopdropdown2.find("option:not(:selected)").map(function() {
                if ($(this).val() != "") {
                    return $(this).val();
                }
            }).get();

            $.each(Options1, function(key, val) {
                if ($.inArray(val, mergevalue) !== -1) {
                    scopdropdown1.find('option[value="' + val + '"]').prop('disabled', true).css(
                        "background-color", "#e5e5e5");
                } else {
                    scopdropdown1.find('option[value="' + val + '"]').prop('disabled', false).css(
                        "background-color", "");
                }
            });
            $('#scope1').selectpicker('refresh');

            $.each(Options2, function(key, val) {
                if ($.inArray(val, mergevalue2) !== -1) {
                    scopdropdown2.find('option[value="' + val + '"]').prop('disabled', true).css(
                        "background-color", "#e5e5e5");
                } else {
                    scopdropdown2.find('option[value="' + val + '"]').prop('disabled', false).css(
                        "background-color", "");
                }
            });
            $('#scope2').selectpicker('refresh');
        });

        $("#industry").change(function(){
            $("#scope1").val("");
            $('#scope1').selectpicker('refresh');
            $("#scope2").val("");
            $('#scope2').selectpicker('refresh');
            $("#scope3").val("");
            $('#scope3').selectpicker('refresh');

            var id= $(this).val();
            var current_url_edit = "{{ url('admin/scopes/edit') }}"+'/'+id;
            window.location.href = current_url_edit;
        });


    </script>
@endsection
