<html>
<head>
    <title>Delivery List Report</title>
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
<br/>

<div style="text-align: center">
    <b style="font-size: 2.2rem">Basar Himager Limited</b> <br/>
    <span style="font-size: 1.2rem">Chanpara, Bhabaniganj, Bagmara, Rajshahi</span> <br/> <br/>

    <div style=" border: 3px solid black; width: 45%; border-radius: 8px; margin: auto">
        <b style="font-size: 1.5rem;padding: 20px">আলু ডেলিভারী প্রতিবেদন (@if($type) অগ্রীম @else সাধারণ @endif ) </b> <br/>

    </div>

</div>
<br>

<div>
    <p><b>তারিখ:</b> {{ date('F d, Y', strtotime($start_date)) }}</p>
</div>
<table class="bordertable">
    <thead>
    <tr>
        <th width="20%">তারিখ</th>
        <th width="15%">বুকিং নং</th>
        <th width="20%">এস আর/লট সংখ্যা</th>
        <th>ডি ও নং</th>
        <th>শেষ অবস্থান</th>
        <th>লোন</th>
        <th>লোনের সার র্চাজ</th>
        <th width="15%">মোট টাকা</th>
    </tr>
    </thead>
    <tbody>
    @if(count($statements))
        @foreach($statements as $statement)
            @foreach($statement->deliveries as $delivery)
                @foreach($delivery->deliveryitems as $deliveryitem)
                    @if($delivery->booking->type == $type)
                        <tr>
                            <td>{{ date('F d, Y', strtotime($statement->delivery_time))}}</td>
                            <td>{{$delivery->booking->booking_no}}</td>
                            <td>{{$deliveryitem->srlot_no}}</td>
                            <td>{{$statement->delivery_no}}</td>
                            <td>
                                @if( count($deliveryitem->unloadings))
                                    Compartment: {{$deliveryitem->unloadings[0]->loaddistribution->inventory_tree->name}} <br/>
                                    Floor: {{$deliveryitem->unloadings[0]->loaddistribution->inventory_tree->parent_info->name}} <br/>
                                    Chamber: {{$deliveryitem->unloadings[0]->loaddistribution->inventory_tree->parent_info->parent_info->name}}
                                @endif
                            </td>
                            <td>
                                {{$delivery->deliverygroup->loancollection->sum('payment_amount')}}
                            </td>
                            <td>
                                {{$delivery->deliverygroup->loancollection->sum('surcharge')}}
                            </td>
                            <td>{{$delivery->total_charge + $delivery->do_charge + $delivery->quantity_bags_fanned * $delivery->fancost_per_bag + $delivery->deliverygroup->loancollection->sum('payment_amount') + $delivery->deliverygroup->loancollection->sum('surcharge')}}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        @endforeach
    @endif
    </tbody>
</table>


{{--<pagebreak/>--}}


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
                    <p>Basar Himager Limited</p>
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