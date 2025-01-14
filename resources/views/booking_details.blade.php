<html>
<head>
    <title>Booking Receipt</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'Kalpurush', 'AdorshoLipi', sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        th, td {
            /*padding: 7px;*/
            font-family: 'Kalpurush', 'AdorshoLipi', sans-serif;
            font-size: 15px;
        }

        .bordertable td, th {
            border: 1px solid black;
        }

        .present {
            color: #218838;
        }

        .absent {
            color: #F03A17;
        }

        .storeWaterMark {
            text-align: center;
            font-size: 30px;
            color: #b8cee3;
            opacity: 0.1 !important;
        }

        .footer {
            position: fixed;
            bottom: 20px;
        }

        @page {
            header: page-header;
            footer: page-footer;
            background: url({{ public_path('images/bhl_bg2.png') }});
            background-repeat: no-repeat;
            background-position: center center;
        }
    </style>
</head>
<body>
<br />

<div style="text-align: center">
    <b style="font-size: 2.2rem">Cold Storage Limited</b> <br />
    <span style="font-size: 1.2rem">Tejgaon, Dhaka</span> <br /> <br/>

    <div style=" border: 3px solid black; width: 45%; border-radius: 8px; margin: auto">
        <b style="font-size: 1.6rem;padding: 20px">বুকিং রশিদ(বিস্তারিত)</b> <br />

    </div>

</div>
<span align="center" style="line-height: 1.2;">
    <p><b>বুকিং নম্বর:</b> {{$bookinginfo->booking_no}}</p>
    <p><b>তারিখ:</b> {{ date('F d, Y') }}</p>
</span>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>গ্রাহকের তথ্য</h3>
                <div>
                    <p><b>নাম:</b> {{$bookinginfo->client->name}}</p>
                    <p><b>ফোন নম্বর:</b> {{$bookinginfo->client->phone}}</p>
                    <p><b>বাবার নাম</b>: {{$bookinginfo->client->father_name}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
        </td>
    </tr>

</table>
<div style="text-align: center; padding-bottom: 10px; font-size: 1.2em">
    <span><b>বুকিং তথ্য</b></span>
</div>
<table>
    <tr>
        <td style="width: 70%; text-align: left">
            <div   >
                <div>
                    <p><b>বুকিং তারিখ:</b> {{ date('F d, Y', strtotime($bookinginfo->booking_time)) }}</p>
                    <p><b>মোট পরিমাণ:</b> {{$bookinginfo->quantity}}</p>
                </div>
            </div>
        </td>
        <td  class="td-right-align" style="width: 30%; text-align: left">
            <div>
                <p><b>বুকিং ধরন:</b>
                    @if($bookinginfo->type == 0)
                        Normal
                    @elseif($bookinginfo->type == 1)
                        Advance
                    @endif
                </p>

                @if($bookinginfo->advance_payment > 0)
                    <p><b>অগ্রীম পরিশোধ:</b> {{$bookinginfo->advance_payment}}</p>
                @elseif($bookinginfo->booking_amount > 0)
                    <p><b>বুকিং মানি:</b> {{$bookinginfo->initial_booking_amount}}</p>
                    <p><b>অবশিষ্ট:</b> {{$bookinginfo->booking_amount}}</p>
                @endif
            </div>
        </td>
    </tr>

</table>

<div style="text-align: center; padding-bottom: 10px; padding-top: 10px; font-size: 1.2em">
    <span><b>রিসিভ তথ্য</b></span>
</div>

<table class="bordertable">
    <thead>
    <tr>
        <th>বুকিং নং</th>
        <th>বুকিং পরিমাণ</th>
        <th>SR/লট নং</th>
        <th>পরিবহন</th>
        <th>আলুর ধরন</th>
    </tr>

    </thead>
    <tbody>
    @if(count($bookinginfo->receives))
        @foreach($bookinginfo->receives as $receive)
            <tr>
                <td>{{$receive->booking->booking_no}}</td>
                <td>{{$receive->booking_currently_left}}</td>
                <td>{{$receive->lot_no}}</td>
                <td>{{ucfirst($receive->transport['type'])}} ({{$receive->transport['number']}})</td>
                <td>
                    @foreach($receive->receiveitems as $item)
                        {{$item->potato_type}} ({{$item->quantity}}) <br />
                    @endforeach
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>


<div style="text-align: center; padding-bottom: 10px; padding-top: 10px;font-size: 1.2em">
    <span><b>ডেলিভারি তথ্য</b></span>
</div>

<table class="bordertable">
    <thead>
    <tr>
        <th>বুকিং নম্বর</th>
        <th>আলুর ধরন</th>
        <th>চার্জ</th>
        <th>মোট</th>
    </tr>

    </thead>
    <tbody>
    @if(count($bookinginfo->deliveries))
        @foreach($bookinginfo->deliveries as $delivery)
            <tr>
                <td>{{$delivery->booking->booking_no}}</td>
                <td>
                    @foreach($delivery->deliveryitems as $item)
                        {{$item->potato_type}} ({{$item->quantity}}) <br />
                    @endforeach
                </td>
                <td>
                    <p>মোট ব্যাগ: {{$delivery->deliveryitems->sum('quantity')}}</p>
                    <p>বস্তা প্রতি খরচ: {{$delivery->cost_per_bag}}</p>
                    <p>বস্তা প্রতি ডি.ও চার্জ: {{$delivery->do_charge}}</p>
{{--                    <p>ফ্যান খরচ: {{$delivery->quantity_bags_fanned}}({{$delivery->fancost_per_bag}})</p>--}}
                </td>
                <td>{{$delivery->total_charge}} ৳</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>

<div class="page-break"></div>

<div style="text-align: center; padding-bottom: 10px; padding-top: 10px;font-size: 1.2em">
    <span><b>লোন বিবরণ</b></span>
</div>

<table class="bordertable">
    <thead>
    <tr>
        <th>লোন বিতরণের নং</th>
        <th>তারিখ</th>
        <th>লোনের পরিমান</th>
        <th>পরিশোধ করতে হবে</th>
    </tr>

    </thead>
    <tbody>
    @if(count($bookinginfo->loanDisbursements))
        @foreach($bookinginfo->loanDisbursements as $loanDisbursement)
            <tr>
                <td>{{$loanDisbursement->loandisbursement_no}}</td>
                <td>{{ date('F d, Y', strtotime($loanDisbursement->payment_date)) }}</td>
                <td>{{$loanDisbursement->amount}}</td>
                <td>{{$loanDisbursement->amount_left}}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>

<div style="text-align: center; padding-bottom: 10px; padding-top: 10px;font-size: 1.2em">
    <span><b>লোন সংগ্রহ</b></span>
</div>

<table class="bordertable">
    <thead>
    <tr>
        <th>ডি ও নং</th>
        <th>তারিখ</th>
        <th>সারচার্জ</th>
        <th>পরিমান</th>
    </tr>

    </thead>
    <tbody>
    @if(count($bookinginfo->loanDisbursements))
        @php
            $surcharge = 0;
            $payment_amount = 0;
            $total = 0;
        @endphp
        @foreach($bookinginfo->loanDisbursements as $loanDisbursement)
            @if(count($loanDisbursement->loancollections))
                @foreach($loanDisbursement->loancollections as $collection)
                    <tr>
                        <td>{{$collection->deliverygroup->delivery_no}}</td>
                        <td>{{ date('F d, Y', strtotime($collection->payment_date)) }}</td>
                        <td>{{$collection->surcharge}}</td>
                        <td>{{$collection->payment_amount}}</td>
                    </tr>
                    @php
                        $surcharge += $collection->surcharge;
                        $payment_amount += $collection->payment_amount;
                        $total += $collection->surcharge + $collection->payment_amount;
                    @endphp
                @endforeach
            @endif
        @endforeach
        <tr>
            <td></td>
            <td> <b>SUBTOTAL:</b></td>
            <td> <b>{{$surcharge}}</b></td>
            <td> <b>{{$payment_amount}}</b></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td> <b>TOTAL:</b></td>
            <td><b>{{$total}} </b></td>
        </tr>
    @endif
    </tbody>
</table>

<htmlpageheader name="page-header">
    <table>
        <tr>
            <td align="left" width="50%" style="padding: 0">
                <small style="font-size: 12px; color: #525659;">download time: <span
                        style="font-family: Calibri; font-size: 12px;">{{ date('F d, Y, h:i A') }}</span></small>
            </td>
            <td align="right" style="color: #525659;">
                <small>
                    | page: {PAGENO}/{nbpg}
                </small>
            </td>
        </tr>
    </table>
</htmlpageheader>


<htmlpagefooter name="page-footer">

    <table>
        <tr>
            <td width="50%" align="left" style="padding: 0">
                <div class="storeWaterMark" style="opacity: 0.1;">
                    <p>Cold Storage Limited</p>
                    {{--        @if($store->slogan)--}}
                    {{--            <br/>** {{ $store->slogan }} **--}}
                    {{--        @endif--}}
                </div>

            </td>
            <td align="right">
               <span style="font-family: Calibri; font-size: 11px; color: #3f51b5;">Generated by:
                    https://basarhimager.com</span> <br/>
                <small style="font-family: Calibri; font-size: 11px; color: #3f51b5;">Powered by:
                    https://innovabd.tech (01515297658)</small>
            </td>
        </tr>
    </table>

</htmlpagefooter>
</body>
</html>
