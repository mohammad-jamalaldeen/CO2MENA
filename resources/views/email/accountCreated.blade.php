@include('email.commonheader')
<tr>
    <td
        style="padding:25px 25px 5px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:700">
        Dear {{ $data['name'] }},
    </td>
</tr>
<tr>
    <td
        style="padding:5px 25px 25px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400">
        Your account is created. Account credentials are listed below.
    </td>
</tr>
<tr>
    <td
        style="padding:25px 25px 10px; text-align:left; vertical-align:top; background-color:#ffffff; font-family:'verdana', Helvetica, Arial, sans-serif !important; color:#204C65; font-size:16px; line-height:20px; font-weight:600; border-top:1px solid #D5E2DE">
        Credentials:
    </td>
</tr>
<tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%; background-color:#ffffff">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:15%;">
                    Email:</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:85%;">
                    {{ $data['email'] }}</td>
            </tr>
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:15%;">
                    Password:</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:85%;">
                    {{ $data['password'] }}</td>
            </tr>
            <tr>
                <td colspan="2"
                    style="padding:25px 0px 10px; text-align:left; vertical-align:top; background-color:#ffffff; font-family:'verdana', Helvetica, Arial, sans-serif !important; color:#204C65; font-size:16px; line-height:20px; font-weight:600; border-top:1px solid #D5E2DE; text-align:center;">
                    @if (!empty($data['user_role_id']) && in_array($data['user_role_id'], [7,8,9]))
                        <a href="{{ route('web.login') }}" target="_blank" class="btn btn-success"
                            style="display: inline-block; padding: 8px 20px; font-size: 16px; line-height: 20px; text-decoration: none; background-color:#32AE59; color:#FFF; border-radius:10px">Click
                            here..</a>
                    @else
                        <a href="{{ route('admin.login') }}" target="_blank" class="btn btn-success"
                            style="display: inline-block; padding: 8px 20px; font-size: 16px; line-height: 20px; text-decoration: none; background-color:#32AE59; color:#FFF; border-radius:10px">Click
                            here..</a>
                    @endif
                </td>
            </tr>
        </table>
    </td>
</tr>
@include('email.commonfooter')
