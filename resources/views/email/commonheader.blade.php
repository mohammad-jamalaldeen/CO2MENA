<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    {{-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> --}}
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>Co2Mena - Email</title>
    <style type="text/css">
        body {
            width: 100%;
            height: 100vh;
            overflow: auto;
            background: transparent linear-gradient(180deg, #D8E3EB 0%, #F0F9F6 100%);
            line-height: 18px;
            margin: 0;
            font-family: 'verdana', Helvetica, Arial, sans-serif !important;
            color: #204C65;
            font-size: 14px;
            line-height: 20px;
            font-weight: 400
        }
    </style>
</head>

<body>
    <table style="margin:0 auto;text-align:center;width:100%;border:0;padding:0;" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0"
                    style="text-align:left;vertical-align:top;width:700px;margin:0 auto;background-color:#ffffff;max-width:700px">
                    <tr>
                        <td
                            style="padding:25px 20px;border-bottom:2px solid #D5E2DE; background-color:#ffffff; text-align:center;vertical-align:middle;">
                            @php
                                if(is_array($data))
                                { 
                                    $company_logo = strpos($data['company_logo'], 'No_profile_picture.jpeg') ? asset('assets/images/logo.png') : $data['company_logo'];
                                } else 
                                {
                                    if(isset($data->company_logo))
                                    {
                                        $company_logo = strpos($data->company_logo, 'No_profile_picture.jpeg') ? asset('assets/images/logo.png') : $data->company_logo;
                                    } else {
                                        $company_logo = asset('assets/images/logo.png');   
                                    }
                                    
                                }
                            @endphp
                            <a href="#"
                                style="display:inline-block;text-decoration:none;color:#fff;outline:none"><img
                                    src="{{ ($company_logo != null) ? $company_logo : asset('assets/images/logo.png')}}" alt="logo"
                                    style="width: 100px;" /></a>
                        </td>
                    </tr>