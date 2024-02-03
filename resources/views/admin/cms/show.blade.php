@extends('admin.layouts.app')
@section('title')
View CMS
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cms.index') }}">CMS Management</a></li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="customer-support">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <table id="w0" class="table  table-bordered detail-view detail-view-table">
                        <tbody>
                            <tr>
                                <th>Title</th>
                                <td>{{ !empty($cms->title) ? $cms->title : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{ !empty($cms->slug) ? $cms->slug : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>@if($cms->status == 1)Active @elseif($cms->status == 0)Inactive @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>Content</th>
                                <td>@if (!empty($cms->content))
                                    {!! $cms->content !!}
                                @else
                                    N/A
                                @endif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
@endsection
