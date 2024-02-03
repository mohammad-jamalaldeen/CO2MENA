<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!--  Title Name  -->
    <title>PDF</title>

    
  </head>
  <body>
    <table style="width: 100%; max-width: 1800px; margin: 0 auto; background-color: #FFF; padding: 0;">
        <tr>
            <td>
                <table style="width: 100%; padding: 0;">
                    <tr>
                        <table style="width: 100%;padding-bottom:15px;border-bottom:1px solid #D5E2DE;">
                            <tr>
                                <td style="text-align:left;vertical-align:middle;" colspan="0">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" title="logo" width="167" height="40" />
                                </td>
                            </tr>
                        </table>
                    </tr>
                    {{-- <tr>
                        <td>
                            <table style="width: 100%; padding: 0;">
                                <tr>
                                    <td style="font-size: 24px; line-height: 30px; color: #204C65; font-family: sans-serif; font-weight: 700;">
                                        Dashboard
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> --}}
                    <tr>
                        <td>
                            <table style="width: 100%; padding: 0;" cellspacing="15">
                                <tr>
                                    <td style="padding: 12px; border: 1px solid #D5E2DE; background-color: #F0F9F6; color: #204C65; border-radius: 24px;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="font-family: sans-serif; font-weight: 700; width:70%; color: #204C65; font-size: 12px;">TOTAL ACTIVITY SHEETS</td>
                                                <td style="font-family: sans-serif; width: 30%; text-align: right; color: #32AE59; font-size: 24px; line-height: 30px; font-weight: 700;">{{ $totalDatasheets }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding: 12px; border: 1px solid #D5E2DE; background-color: #F0F9F6; color: #204C65; border-radius: 24px;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="font-family: sans-serif; font-weight: 700; width:70%; color: #204C65; font-size: 12px;">TOTAL SUB ADMIN  MEMBERS</td>
                                                <td style="font-family: sans-serif; width: 30%; text-align: right; color: #32AE59; font-size: 24px; line-height: 30px; font-weight: 700;">{{ $totalSubAdminMembers }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding: 12px; border: 1px solid #D5E2DE; background-color: #F0F9F6; color: #204C65; border-radius: 24px;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="font-family: sans-serif; font-weight: 700; width:70%; color: #204C65; font-size: 12px;">TOTAL CUSTOMER MEMBERS</td>
                                                <td style="font-family: sans-serif; width: 30%; text-align: right; color: #32AE59; font-size: 24px; line-height: 30px; font-weight: 700;">{{ $totalCustomereMembers }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="width: 100%; padding: 0;">
                                @if(!empty($chartBarArr))
                                @php $i = 1;@endphp
                                @foreach($chartBarArr as $key =>  $value)
                                @if($i % 2 != 0)
                                    <tr>
                                @endif
                                        <td style="width: 50%; padding: 16px; border: 1px solid #D5E2DE; border-radius: 24px; vertical-align: top;">
                                            <table style="width: 100%; padding: 0;">
                                                <tr>
                                                    <td style="color: #204C65; font-size: 12px; line-height: 24px;height: 24px; padding-bottom: 20px; font-weight: 600; text-transform: uppercase;">{{$key == "uploaded datasheets" ? "Uploaded Activity Sheets":$key}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <img src="{{ $value }}" alt="datasheet-graph" title="datasheet-graph" style="width: auto; max-width: 100%;">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    @if($i % 2 == 0)    
                                        </tr>
                                        @if($i % 4 == 0)
                                            <tr style="page-break-before:always"><td colspan="2" style="height: 20px;"></td></tr>
                                        @endif
                                    @endif
                                    @php  $i++  @endphp
                                @endforeach
                                @endif
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    
  </body>
</html>
