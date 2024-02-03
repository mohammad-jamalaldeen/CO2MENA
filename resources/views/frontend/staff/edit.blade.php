@extends('frontend.layouts.main')

@section('title')
    Staff Member Edit
@endsection
@section('content')
    <div class="customer-support">
        <form class="input-form" id="staff-member-edit" method="POST" action="{{ route('staff.update',[$user->id]) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="name">MEMBER NAME</label>
                        <input type="text" name="name" id="name" value="{{ $user->name ?? old('name') }}"
                            placeholder="Juma Majid" class="form-controal">
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
                        <input type="text" name="email" id="email" value="{{ $user->email ?? old('email') }}"
                            placeholder="juma.majid@abcco.com" class="form-controal">
                        @error('email')
                            <span class="error-mgs">
                                <strong> {{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
                {{-- <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label >Username</label>
                        <input type="text" name="username" value="{{ $user->username ?? old('username') }}"
                            value="{{ old('username') }}" placeholder="juma.majid@abcco.com" class="form-controal">
                        @error('username')
                            <span class="error-mgs">
                                <strong> {{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div> --}}

                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="contact_number">PHONE</label>
                        <input type="text" name="contact_number" id="contact_number"
                            value="{{ $user->contact_number ?? old('contact_number') }}" placeholder="Enter contact number"
                            class="form-controal">
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
                        <select name="role" id="role">
                            <option value="" disabled>Select Role</option>
                            @if ($staffrole)
                                @foreach ($staffrole as $role)
                                    <option {{ ($role->id == $user->role_id) ? 'selected' : ''; }} value="{{ $role->id }}">{{ $role->role }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="status">STATUS</label>
                        <select name="status" id="status">
                            @php
                                if($user->status == 1){
                                    $active = 'Selected';
                                }else{
                                    $active = '';
                                }
                                if($user->status == 0){
                                    $inActive = 'Selected';
                                }else{
                                    $inActive = '';
                                }
                            @endphp
                            <option {{ $active }} value="1">Active</option>
                            <option {{ $inActive }} value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="towbutton-row">
                        <a href="{{ route('staff.index') }}" class="btn-primary" title="cancel">Cancel</a>
                        <button type="submit" class="btn-primary" title="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
