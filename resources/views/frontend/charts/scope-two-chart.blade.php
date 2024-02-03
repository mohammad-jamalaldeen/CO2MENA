<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    {{-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> --}}
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
   
    <!--  Title Name  -->
    <title>PDF</title>
    <style>
        .page-break {
          page-break-before: auto;
          page-break-after: auto;
          page-break-inside: avoid;
      }

      /** Define the margins of your page **/
      @page {
          margin: 100px 25px;
      }

      header {
          position: fixed;
          top: -60px;
          left: 0px;
          right: 0px;
          height: 50px;

          /** Extra personal styles **/
          /* background-color: #03a9f4; */
          /* color: white; */
          text-align: center;
          line-height: 35px;
      }

      footer {
          position: fixed;
          bottom: -80px;
          left: 0px;
          right: 0px;
          height: 50px;

          /** Extra personal styles **/
          /* background-color: #03a9f4; */
          /* color: white; */
          text-align: right;
          line-height: 35px;
      }

      .pagenum:before {
          content: counter(page);
      }
  </style>
  </head>
  <body>
    <header>
        <table style="width: 100%;padding-bottom:15px;border-bottom:1px solid #D5E2DE;">
            <tr>
                <td style="text-align:left;vertical-align:middle;" colspan="0">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" width="167"
                        height="40" />
                </td>
                
                <td style="font-family: sans-serif;text-align: right; color: #32AE59; font-size: 18px; line-height: 22px;font-weight: 700;vertical-align:middle;"
                    colspan="0">
                    <span
                        style="padding-bottom: 10px;display:block;text-transform:capitalize;">{{ $companyData->company_name }}</span>
                        @if(!str_contains($companyData->company_logo, 'No_image_available.png'))
                            <img src="{{ $companyData->company_logo }}" alt="datasheet-graph" style="height:30px;max-width:150px;" height="30" />
                        @endif
                </td>
            </tr>
        </table>
    </header>
    <footer>
        <p>Page <span class="pagenum"></span></p>
    </footer>
    <table style="width: 100%; max-width: 1800px; margin: 0 auto; background-color: #FFF; padding: 0;">
        <tr>
            <td>
                <table style="width: 100%; padding: 15px 0 0 0;">
                    <tr>
                        <td style="width: 100%;">
                            <table style="width: 100%; padding: 0;" cellspacing="15">
                                <tr>
                                    <td style="width:50%;text-align:left;">
                                        <table style="width: 100%;padding:0;">
                                            <tr>
                                                <td style="width:50%;font-family: sans-serif;font-weight: 700;color: #204C65; font-size: 12px;padding-bottom:15px;">Company Account Id</td>
                                                <td style="width:50%;font-family: sans-serif;text-align: right; color: #32AE59; font-size: 14px;line-height: 16px; font-weight: 700;padding-bottom:15px;">{{ $companyData->company_account_id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:50%;font-family: sans-serif; font-weight: 700;color: #204C65; font-size: 12px;padding-bottom:15px;">Name of Sheet</td>
                                                <td style="width:50%;font-family: sans-serif;text-align: right; color: #32AE59; font-size: 14px; line-height: 16px; font-weight: 700;padding-bottom:15px;">{{ $datasheet->data_assessor }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:50%;font-family: sans-serif; font-weight: 700;color: #204C65; font-size: 12px;padding-bottom:15px;">Description</td>
                                                <td style="width:50%;font-family: sans-serif;text-align: right; color: #32AE59; font-size: 14px; line-height: 16px; font-weight: 700;padding-bottom:15px;">{{ $datasheet->description }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width:50%;text-align:right;">
                                        <table style="width: 100%;padding:0;">
                                            
                                            <tr>
                                                <td style="width:35%;font-family: sans-serif;font-weight: 700;color: #204C65; font-size: 12px;padding-bottom:15px;">Email Address</td>
                                                <td style="width:65%;font-family: sans-serif;text-align: right; color: #32AE59; font-size: 14px; line-height: 16px; font-weight: 700;padding-bottom:15px;">{{ $companyData->company_email }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:35%;font-family: sans-serif; font-weight: 700;color: #204C65; font-size: 12px;padding-bottom:15px;">Reporting Period</td>
                                                <td style="width:65%;font-family: sans-serif;text-align: right; color: #32AE59; font-size: 14px; line-height: 16px; font-weight: 700;padding-bottom:15px;">{{ $datasheet->reporting_start_date }} / {{ $datasheet->reporting_end_date }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:35%;font-family: sans-serif; font-weight: 700;color: #204C65; font-size: 12px;padding-bottom:15px;">Activity scopes</td>
                                                <td style="width:65%;font-family: sans-serif;text-align: right; color: #32AE59; font-size: 14px; line-height: 16px; font-weight: 700;padding-bottom:15px;">Scope -2</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="width: 100%; padding: 0;"  cellspacing="15">
                                <tr>
                                    <td style="padding: 12px; border: 1px solid #D5E2DE; background-color: #F0F9F6; color: #204C65; border-radius: 24px;vertical-align:top;width:33.33%;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="font-family: sans-serif;font-weight: 700;color: #204C65; font-size: 12px; text-align:center">
                                                    TOTAL EMISSIONS
                                                    {{-- <span style="display: block;font-family: sans-serif;font-weight: 400;color: #204C65; font-size: 12px;">Kg CO2-eq</span> --}}
                                                </td>                                            
                                            </tr>
                                            <tr>
                                                <td style="font-family: sans-serif;color: #32AE59; font-size: 16px; line-height: 18px; font-weight: 700; text-align:center">{{ $totalEmission }} Kg-co2-eq</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding: 12px; border: 1px solid #D5E2DE; background-color: #F0F9F6; color: #204C65; border-radius: 24px;vertical-align:top;width:33.33%;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="font-family: sans-serif; font-weight: 700;color: #204C65; font-size: 12px; text-align:center">
                                                    TOTAL ENERGY USED
                                                    {{-- <span style="display: block;font-family: sans-serif;font-weight: 400;color: #204C65; font-size: 12px;">Kwh</span> --}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-family: sans-serif;color: #32AE59; font-size: 16px; line-height: 18px; font-weight: 700; text-align:center">{{ $totalEnergyUsed }} Kwh</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding: 12px; border: 1px solid #D5E2DE; background-color: #F0F9F6; color: #204C65; border-radius: 24px;vertical-align:top;width:33.33%;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="font-family: sans-serif; font-weight: 700;color: #204C65; font-size: 12px; text-align:center">
                                                    TON Of REFRIGERATION USED
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-family: sans-serif;color: #32AE59; font-size: 16px; line-height: 18px; font-weight: 700; text-align:center">{{ $totalTonOfRefrigeration }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="width: 100%; padding: 0;" cellspacing="15">
                                @if(!empty($chartBarArr))
                                @php $i = 1;@endphp
                                @foreach($chartBarArr as $key =>  $value)
                                @if($i % 2 != 0)
                                    <tr>
                                @endif
                                        <td style="width: 50%; padding: 16px; border: 1px solid #D5E2DE; border-radius: 24px; vertical-align: top;">
                                            <table style="width: 100%; padding: 0;">
                                                <tr>
                                                    <td style="color: #204C65; font-size: 12px; line-height: 24px; padding-bottom: 20px; font-weight: 600; text-transform: uppercase;">{{$key == "myDoughnutChart" ? "Overview":str_replace('_', ' ', $key)}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <img src="{{ $value }}" alt="datasheet-graph" style="width: auto; max-width: 100%;">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    @if($i % 2 == 0)    
                                        </tr>
                                        @if($i < 3 &&  $i % 2 == 0)
                                            <tr style="page-break-before:always"><td colspan="2" style="height: 20px;"></td></tr>
                                        @endif
                                    @endif
                                    {{$i++}}
                                @endforeach
                                </tr>
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
