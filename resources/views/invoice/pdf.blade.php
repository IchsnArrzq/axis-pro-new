<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<style>
    html {
        font-family: Sans-serif
    }

    table {
        font-size: 11px;
    }
</style>

<body>
    <img src="{{ asset('/asset/header.PNG') }}" alt="">
    <h5 class="text-center"><b>
            @if($invoice->type_invoice == 1)
            INTERIM INVOICE
            @endif
            @if($invoice->type_invoice == 2)
            PERFORMA INVOICE
            @endif
            @if($invoice->type_invoice == 3)
            FINAL INVOICE
            @endif
        </b></h5>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table cellpadding="0">
                    <tr>
                        <th width="150">Invoice Number</th>
                        <th width="10">:</th>
                        <th>{{ $invoice->no_invoice }}</th>
                    </tr>
                    <tr>
                        <th width="150">Our Reference</th>
                        <th width="10">:</th>
                        <td>{{ $invoice->caselist->file_no }}/{{ $invoice->caselist->adjuster->kode_adjuster }}</td>
                    </tr>
                </table>
            </div>
            <div class="col" style="margin-left: 60%;">
                <table>
                    <tr>
                        <th>Date</th>
                        <th width="100">:</th>
                        <td>{{ Carbon\Carbon::parse($invoice->date_invoice)->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table cellpadding="5">
                    <tr>
                        <th>To.</th>
                    </tr>
                </table>
            </div>
            <div class="col" style="margin-left :10%">
                <table cellpadding="2">
                    <tr>
                        <th>{{ $invoice->member->name }}</th>
                    </tr>
                    <tr>
                        <td>{{ $invoice->member->address }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <hr style="border : 2px double black; margin-top: -15px;">
        <div class="row">
            <div class="col">
                <table cellpadding="5">
                    <tr>
                        <th>Re</th>
                    </tr>
                </table>
            </div>
            <div class="col" style="margin-left :10%">
                <table cellpadding="0">
                    <tr>
                        <th width="100">Client</th>
                        <th width="10">:</th>
                        <th>{{ $invoice->caselist->insured }}</th>
                    </tr>
                    @if($caselist->category == 1)
                    <tr>
                        <th>Conveyance</th>
                        <th>:</th>
                        <th>{{ $caselist->conveyance }}</th>
                    </tr>
                    @endif
                    @if($caselist->category == 2)
                    <tr>
                        <th>Location Of Loss</th>
                        <th>:</th>
                        <th>{{ $caselist->location_of_loss }}</th>
                    </tr>
                    @endif
                    <tr>
                        <th>Date Of Loss</th>
                        <th>:</th>
                        <th>{{ Carbon\Carbon::parse($invoice->caselist->dol)->format('d M Y') }}</th>
                    </tr>
                    <tr>
                        <th>Insurer's Ref</th>
                        <th>:</th>
                        <th>Not Advised</th>
                    </tr>
                    <tr>
                        <th>Policy No</th>
                        <th>:</th>
                        <th>{{ $invoice->caselist->no_leader_policy }}</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col" style="margin-left:10%;">
                <table>
                    <tr>
                        <th><u>Professional Services</u></th>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <th width="150px">Adjusters Fee</th>
                                    <th width="300px">Your Share</th>
                                    <th>Total</th>
                                </tr>
                                <tr>
                                    <th>{{ $invoice->type_invoice != 1 ? number_format($fee) : 0 }}</th>
                                    <th>{{ $invoice->type_invoice != 1 ? $share : 0 }}</th>
                                    <th>
                                        <p>{{ $invoice->type_invoice != 1 ? $caselist->currency .'.'. number_format($fee * $share / 100) : 0 }}</p>
                                    </th>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th><u>Expenses</u></th>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <th width="150px">Others</th>
                                    <th width="300px">Your Share</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th>{{ number_format($inv->caselist->expense->sum('amount')) }}</th>
                                    <th>{{ $share }}</th>
                                    <th>
                                        <p>{{ $caselist->currency.'.'.number_format($inv->caselist->expense->sum('amount') * $share / 100) }}</p>
                                    </th>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tr>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <th width="150px">Sub Total</th>
                                    <th width="300px"></th>
                                    <th>
                                        <p>{{ $caselist->currency .'.'. number_format(($fee * $share / 100) + ($inv->caselist->expense->sum('amount') * $share / 100)) }}</p>
                                    </th>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <th width="150px">PPN 10%</th>
                                    <th width="300px"></th>
                                    <th>{{ $caselist->currency }}. {{ number_format((($fee * $share / 100) + ($inv->caselist->expense->sum('amount') * $share / 100)) * 10 / 100) }}</th>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <th width="150px">TOTAL AMOUNT DUE</th>
                                    <th width="300px"></th>
                                    <th>{{ $caselist->currency }}. {{ number_format(((($fee * $share / 100) + ($inv->caselist->expense->sum('amount') * $share / 100)) * 10 / 100) + ($fee * $share / 100) + ($inv->caselist->expense->sum('amount') * $share / 100)) }}</th>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <hr style="margin-bottom: 40px;">
        <div class="row">
            <div class="col">
                <table>
                    <tr>
                        <th width="82px">Terms</th>
                        <th>Invoice Payment Upon Receipt. NPWP: 01.310.501.0-018.000</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col" style="width: 550px;">
                <table>
                    <tr>
                        <th>Payments</th>
                        <td style="white-space: pre-line;">
                            Please make payment <strong>no later than 30 days after receipt of this invoice,
                            </strong> and please mail Bank Slip Trasnfer to <strong>finance@axis-adjusters.com</strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col" style="width: 30%;margin-left: 12%;">
                <table>
                    <tr>
                        <th>
                            PT AXIS INTERNASIONAL INDONESIA
                        </th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col" style="width: 30%;margin-left: 12%;">
                @foreach($bank as $data)
                <table>
                    <tr>
                        <th colspan="3">
                            <strong>{{ $data->bank_name }}</strong>
                            <p>{{ $data->address }}</p>
                        </th>
                    </tr>
                    <tr>
                        <th width="100px">Swift Code</th>
                        <th>:</th>
                        <th width="350px">{{ $data->swift_code }}</th>

                        <th><u>Febrizal</u></th>
                    </tr>
                    @foreach($type->where('bank_name',$data->bank_name) as $row)
                    <tr>
                        <th>Account No.{{ $row->currency }}</th>
                        <th>:</th>
                        <th>{{ $row->no_account }}</th>

                        <th>Director</th>
                    </tr>
                    @endforeach
                </table>
                <hr>
                @endforeach
            </div>
        </div>
        <div class="row">
            <!-- <div class="col" style="margin-left: 80%;margin-top:-10px">
                <table>
                    <tr>
                        <th>
                            <u>Febrizal</u><br>
                            Director
                        </th>
                    </tr>
                </table>
            </div> -->
        </div>
        <div class="row" style="clear: both;position: relative;height: 200px;margin-top: -100px;">
            <div class="col" style="margin-left: 60%;">
                <table style="font-size: 8px;">
                    <tr>
                        <th>PT AXIS Internasional Indonesia</th>
                    </tr>
                    <tr>
                        <td>Pakuwon Tower 12 fl. Unit I</td>
                    </tr>
                    <tr>
                        <td>Jl. Casablanca Raya Kav 88</td>
                    </tr>
                    <tr>
                        <td>Jakarta Selatan 12870, Indonesia</td>
                    </tr>
                </table>
            </div>
            <div class="col" style="margin-left: 80%;">
                <table style="font-size: 8px;">
                    <tr>
                        <th>+62 21 2290 3759</th>
                    </tr>
                    <tr>
                        <td>+62 21 2290 3831</td>
                    </tr>
                    <tr>
                        <td>claims@axis-adjusters.com</td>
                    </tr>
                    <tr>
                        <td>www.axis-lossadjusters.com</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>