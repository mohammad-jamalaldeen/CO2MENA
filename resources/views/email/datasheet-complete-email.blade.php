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
        Your uploaded activity sheet calculation is {{ $data['status'] }}. Activity Sheet details are listed below.
    </td>
</tr>
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
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:15%;">
                    Name:</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:85%; text-transform: capitalize;">
                    {{ $data['datasheet_name'] }}</td>
            </tr>
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:15%;">
                    Source Id:</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:85%; text-transform: capitalize;">
                    {{ $data['source_id'] }}</td>
            </tr>
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:15%;">
                    Status:</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:85%; text-transform: capitalize;">
                    {{ $data['status'] }}</td>
            </tr>
        </table>
    </td>
</tr>
@include('email.commonfooter')
