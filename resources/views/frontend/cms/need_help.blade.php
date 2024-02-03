@extends('frontend.layouts.app')
@section('content')
    <div class="customer-support">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cms-content">
                        <h1>{{ $page->title }}</h1>
                        <p>{!! $page->content !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
@endsection
