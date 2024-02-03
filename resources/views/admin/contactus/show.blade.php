@extends('admin.layouts.app')
@section('title')
    View Contact Request Data
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('contactus.index') }}">Contact Request Data Management</a></li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table  table-bordered detail-view detail-view-table">
                    <tbody>
                        <tr><th>Sender Name</th><td>{{!empty($contactinfo['name']) ? $contactinfo['name']:"N/A" }}</td></tr>
                        <tr><th>Sender Email</th><td>{{!empty($contactinfo['email']) ? $contactinfo['email']:"N/A" }}</td></tr>
                        <tr><th>Sender Contact No</th><td>{{!empty($contactinfo['phone_number']) ? $contactinfo['phone_number']:"N/A" }}</td></tr>
                        <tr><th>Mail Subject</th><td>{{!empty($contactinfo['subject']) ? $contactinfo['subject']:"N/A" }}</td></tr>
                        <tr><th>Message</th><td>{{!empty($contactinfo['message']) ? $contactinfo['message']:"N/A" }}</td></tr>
                        <tr><th>Date Of Submission</th><td>{{!empty($contactinfo['created_at']) ? $contactinfo['created_at']:"N/A" }}</td></tr>
                        @if(!empty($contactAttachment))
                        <tr><th colspan="2" style="text-align: center;">Attachement</th></tr>
                        <tr>
                            <td colspan="2">
                                <ul class="list-group list-group-horizontal">
                                    @foreach ($contactAttachment as $attachment)
                                    @php
                                        $fileExtension = pathinfo($attachment['file_name'], PATHINFO_EXTENSION);
                                    @endphp
                                    <li class="list-group-item">
                                        @if ($fileExtension == 'pdf') 
                                            <?php $name = 'pdf.png'; ?>
                                        @elseif (in_array($fileExtension,['webp','mp4','avi'])) 
                                            <?php   $name = 'video.png';  ?>
                                        @elseif (in_array($fileExtension,['doc','docx'])) 
                                            <?php  $name ='doc.jpg'; ?>
                                        @elseif(in_array($fileExtension,['zip','rar'])) 
                                            <?php $name = 'file-img.png'; ?>
                                        @else
                                            <?php $name = 'file-img.png'; ?>
                                        @endif

                                        
                                        @if(in_array($fileExtension,['webp','mp4','avi','pdf','doc','docx','zip','rar']))
                                            <a href="{{$attachment['file_name']}}" target="_blank"
                                                class="a-doc-item" title="attachment">
                                        @endif
                                            <img src="{{in_array($fileExtension,['webp','mp4','avi','pdf','doc','docx','zip','rar']) ? asset('assets/images/'.$name) : $attachment['file_name'] }}"  class="{{ 
                                               (!in_array($fileExtension,['webp','mp4','avi','pdf','doc','docx','zip','rar'])) ? 'imagepop' : '' }}" style="width:123px; height:123px;" alt="attachment-icon" title="attachment">
                                        @if(in_array($fileExtension,['webp','mp4','avi','pdf','doc','docx','zip','rar']))
                                            </a>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection