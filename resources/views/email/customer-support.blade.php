@include('email.commonheader')
<tr>
    <td
        style="padding:25px 25px 5px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:700">
        Dear Admin,
    </td>
</tr>
{{-- <tr>
                            <td
                                style="padding:5px 25px 25px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                                suffered alteration in some form, by injected humour, or randomised words which don't look
                                even slightly believable.
                            </td>
                        </tr> --}}
<tr>
    <td
        style="padding:25px 25px 10px; text-align:left; vertical-align:top; background-color:#ffffff; font-family:'verdana', Helvetica, Arial, sans-serif !important; color:#204C65; font-size:16px; line-height:20px; font-weight:600; border-top:1px solid #D5E2DE">
        Details:
    </td>
</tr>
<tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%; background-color:#ffffff">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:20%;">
                    Name :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:80%; text-transform: capitalize;">
                    {{ $data['name'] }}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%;">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:20%;">
                    Email Address :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:80%;">
                    {{ $data['email'] }}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%;">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:20%;">
                    Contact No. :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:80%;">
                    {{ $data['phone_number'] }}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding:5px 25px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%;">
            <tr>
                <td
                    style="vertical-align:top; font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:20%;">
                    Message :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:80%;">
                    {{ $data['message'] }}</td>
            </tr>
        </table>
    </td>
</tr>
@include('email.commonfooter')
