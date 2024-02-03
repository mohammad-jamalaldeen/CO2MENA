@extends('frontend.layouts.main')

@section('title')
    Staff Member Add
@endsection
<style>
.input-form .invalid-feedback {
    display: block;
}
</style>
@section('content')
    <div class="customer-support">
      <form class="input-form" id="sub-admin-create" method="POST" action="{{ route('staff.store') }}"  enctype="multipart/form-data" >
        @csrf
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="name" >MEMBER NAME</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Juma Majid" 
                    class="form-controal">
                    @error('name')
                    <span class="error-mgs">
                        <strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="email">EMAIL</label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="juma.majid@abcco.com"
                        class="form-controal">
                    @error('email')
                    <span class="error-mgs">
                        <strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
            </div>            
           
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="contact_number">PHONE</label>
                    <input type="text" name="contact_number" value="" id="contact_number" placeholder="Enter contact number" class="form-controal" maxlength='15'>
                     @error('contact_number')
                        <span class="error-mgs">
                            <strong> {{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="role">ROLE</label>
                    <select name="role" id="role" title="Select Role">
                        @if ($staffrole)
                            @foreach($staffrole as $role)
                                <option value="{{$role['id']}}">{{$role['role']}}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('role')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                 <label for="status">STATUS</label>
                <select name="status" id="status" >
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                </div>
            </div>            
            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{route('staff.index')}}" class="btn-primary" title="BACK">BACK</a>
                    <button type="submit" class="btn-primary" title="add">ADD</button>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection
