@include('email.commonheader')
<tr>
    <td
        style="padding:25px 25px 5px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:700">
        Dear {{ $data->user->name }},
    </td>
</tr>
<tr>
    {{-- <td
        style="padding:5px 25px 25px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400">
        Welcome to CO2MENA. Your onboarding process for {{ $data->company_name }} has been completed. Below you will find details of your registration.
    </td> --}}
    <td
        style="padding:5px 25px 25px;text-align:left;vertical-align:top;background-color:#ffffff;font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400">
        Welcome to CO2MENA. Your onboarding process for {{ $data->company_name }} has been completed. Below you will find details of your registration.
    </td>
</tr>
<tr>
    <td
        style="padding:25px 25px 10px; text-align:left; vertical-align:top; background-color:#ffffff; font-family:'verdana', Helvetica, Arial, sans-serif !important; color:#204C65; font-size:16px; line-height:20px; font-weight:600; border-top:1px solid #D5E2DE">
        Details:
    </td>
</tr>
{{-- <tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%; background-color:#ffffff">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                    Name Of Organization :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%; text-transform: capitalize;">
                    {{ $data->company_name }}
                </td>
            </tr>
        </table>
    </td>
</tr> --}}
<tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%;">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                    Email Address :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%;">
                    {{ $data->company_email }}
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%;">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                    Contact Number :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%;">
                    {{ $data->company_phone }}
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%;">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                    Registration No. :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%;">
                    {{ $data->company_account_id }}
                </td>
            </tr>
        </table>
    </td>
</tr>
{{-- <tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%;">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                    Number Of Employees :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%;">
                    {{ $data->no_of_employees }}
                </td>
            </tr>
        </table>
    </td>
</tr> --}}
<tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%;">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                    Industry :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%;">
                    {{ $data->industry->name }}
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding:5px 25px;text-align:left;vertical-align:top;">
        <table style="width:100%;">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                    Emission Scopes :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%;">
                    {{ implode(', ', \Illuminate\Support\Arr::pluck($data->companyactivities->toArray(), 'activity.name')) }}
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding:5px 25px 18px;text-align:left;vertical-align:top;">
        <table style="width:100%;">
            <tr>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:600;width:30%;">
                    Company Address :</td>
                <td
                    style="font-family:'verdana', Helvetica, Arial, sans-serif !important;color:#204C65;font-size:14px;line-height:22px;font-weight:400;width:70%;">
                    @if ($data && $data->companyaddresses && $data->companyaddresses->first())
                        {{ $data->companyaddresses->first()->address }}
                    @endif
                    @if ($data && $data->companyaddresses && $data->companyaddresses->first())
                        {{ $data->companyaddresses->first()->city }}
                    @endif
                    @if ($data && $data->companyaddresses && $data->companyaddresses->first())
                        {{ $data->companyaddresses->first()->country }}
                    @endif
                </td>
            </tr>
        </table>
    </td>
</tr>
@include('email.commonfooter')
