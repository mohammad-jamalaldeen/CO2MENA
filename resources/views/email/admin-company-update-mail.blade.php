@include('email.commonheader')
<tr>
    <td
        style="padding:25px 25px 5px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:700">
        Dear {{ $data['name'] }},
    </td>
</tr>
<tr>
    <td
        style="padding:5px 25px 18px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400">
        {{ $data['content'] }}
    </td>
</tr>
<tr>
    <td
        style="padding:18px 25px 0px; text-align:left; vertical-align:top; background-color:#ffffff; font-family:'verdana', Helvetica, Arial, sans-serif !important; color:#204C65; font-size:16px; line-height:20px; font-weight:600; border-top:1px solid #D5E2DE">
        Details:</td>
</tr>
<tr>
    <td style="padding:5px 25px 15px;text-align:left;vertical-align:top;">
        <table style="width:100%; background-color:#ffffff">
            @if (!empty($data['company_name']))
                <tr>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                        Company Name:</td>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                        {{ $data['company_name'] }}</td>
                </tr>
            @endif
            @if (!empty($data['company_email']))
                <tr>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                        Company Email Address:</td>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                        {{ $data['company_email'] }}</td>
                </tr>
            @endif
            @if (!empty($data['company_phone_number']))
                <tr>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                        Company Contact Number</td>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                        {{ $data['company_phone_number'] }}</td>
                </tr>
            @endif
            @if (!empty($data['trade_licence_number']))
                <tr>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                        Trade License Number:</td>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                        {{ $data['trade_licence_number'] }}</td>
                </tr>
            @endif
            @if (!empty($data['no_of_employees']))
                <tr>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                        No of Employees:</td>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                        {{ $data['no_of_employees'] }}</td>
                </tr>
            @endif
            @if (!empty($data['country']))
                <tr>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                        Country:</td>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                        {{ $data['country'] }}</td>
                </tr>
            @endif
            @if (!empty($data['city']))
                <tr>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                        City:</td>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                        {{ $data['city'] }}</td>
                </tr>
            @endif
        </table>
    </td>
</tr>
@include('email.commonfooter')
