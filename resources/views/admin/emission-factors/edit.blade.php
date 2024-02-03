@extends('admin.layouts.app')
@section('title')
Edit Emission Factor
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('emission-factors.index')}}">Emission Factor Management</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ul>
<div class="customer-support">
    <form class="input-form" id="sub-admin-create" method="POST" action="{{ route('emission-factors.update', $scope->id) }}"  enctype="multipart/form-data" >
      @csrf
      <input type="hidden" name="no" value="{{ $scope->no ?? old('no') }}">
      <div class="row">
          {{-- <div class="col-md-6 col-12">
              <div class="form-group">
                  <label >No</label>
                  <input type="number" name="no" value="{{ $scope->no ?? old('no') }}" placeholder="0123456789" 
                  class="form-controal" readonly>
                  @error('no')
                  <span class="error-mgs">
                      <strong> {{ $message }}</strong>
                  </span>
                  @enderror
              </div>
          </div> --}}
          <div class="col-md-6 col-12">
              <div class="form-group">
                  <label >Name</label>
                  <input type="text" name="name" value="{{ $scope->name ?? old('name') }}" placeholder="Enter name"
                      class="form-controal">
                  @error('name')
                  <span class="error-mgs">
                      <strong> {{ $message }}</strong>
                  </span>
                  @enderror
              </div>
              
          </div>
          
          <div class="col-12">
              <div class="towbutton-row">
                  <a href="{{route('emission-factors.index')}}" title="cancel" class="back-btn">Cancel</a>
                  <button type="submit" class="btn-primary" title="submit">Submit</button>
              </div>
          </div>
      </div>
  </form>
  </div>
@endsection
@section('footer_scripts')
@endsection