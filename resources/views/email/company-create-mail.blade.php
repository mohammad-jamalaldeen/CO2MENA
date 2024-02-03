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
@if (!empty($data['Company_name']) || !empty($data['company_industry']))
    <tr>
        <td
            style="padding:18px 25px 10px; text-align:left; vertical-align:top; background-color:#ffffff; font-family:'verdana', Helvetica, Arial, sans-serif !important; color:#204C65; font-size:16px; line-height:20px; font-weight:600; border-top:1px solid #D5E2DE">
            Details:</td>
    </tr>
    <tr>
        <td style="padding:5px 25px;text-align:left;vertical-align:top;">
            <table style="width:100%; background-color:#ffffff">
                <tr>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                        Company Account Id:</td>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                        {{ $data['account_id'] }}</td>
                </tr>
                <tr>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                        Company Name:</td>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                        {{ $data['Company_name'] }}</td>
                </tr>
                <tr>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                        Company Email:</td>
                    <td
                        style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                        {{ $data['Company_Email'] }}</td>
                </tr>
                @if (!empty($data['company_industry']))
                    <tr>
                        <td
                            style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                            Company Industry:</td>
                        <td
                            style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                            {{ $data['company_industry'] }}</td>
                    </tr>
                @endif
            </table>
        </td>
    </tr>
@endif
<tr>
    <td
        style="padding:18px 25px 0px; text-align:left; vertical-align:top; background-color:#ffffff; font-family:'verdana', Helvetica, Arial, sans-serif !important; color:#204C65; font-size:16px; line-height:20px; font-weight:600; border-top:1px solid #D5E2DE">
        Credentials:</td>
</tr>
<tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%; background-color:#ffffff">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                    Email:</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%;">
                    {{ $data['user_email'] }}</td>
            </tr>
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%; padding-bottom:15px;">
                    Password:</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; padding-bottom:15px;">
                    {{ $data['password'] }}</td>
            </tr>
            <tr>
                <td colspan="2"
                    style="padding:18px 0px 10px; text-align:left; vertical-align:top; background-color:#ffffff; font-family:'verdana', Helvetica, Arial, sans-serif !important; color:#204C65; font-size:16px; line-height:20px; font-weight:600; border-top:1px solid #D5E2DE; text-align:center;">
                    <a href="{{ route('web.login') }}" target="_blank" class="btn btn-success"
                        style="display: inline-block; padding: 8px 20px; font-size: 16px; line-height: 20px; text-decoration: none; background-color:#32AE59; color:#FFF; border-radius:10px">Click
                        here..</a>
                </td>
            </tr>
        </table>
    </td>
</tr>
@include('email.commonfooter')
