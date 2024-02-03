@include('email.commonheader')
<tr>
    <td
        style="padding:25px 25px 5px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:700">
        Dear {{ ucwords($data['username']) }},
    </td>
</tr>
<tr>
    <td
        style="padding:5px 25px 25px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400">
        One-time password (OTP) is sent to the this email address.
    </td>
</tr>
<tr>
    <td
        style="padding:5px 25px 25px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:16px;line-height:20px;font-weight:600">
        {{ $data['otp'] }}
    </td>
</tr>
@include('email.commonfooter')
