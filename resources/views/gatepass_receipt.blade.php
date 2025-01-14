@extends('layouts.receipt')

@section('title')
    Gatepass
@endsection


@section('receipt-title')
    গেট পাস
@endsection
@section('content')
    {{--<div style="text-align: center">--}}
    {{--    <b style="font-size: 2.2rem">Cold Storage Limited</b> <br />--}}
    {{--    <span style="font-size: 1.2rem">Tejgaon, Dhaka</span> <br /> <br/>--}}

    {{--    <div style=" border: 3px solid black; width: 45%; border-radius: 8px; margin: auto">--}}
    {{--        <b style="font-size: 1.6rem;padding: 20px">গেট পাস</b> <br />--}}

    {{--    </div>--}}

    {{--</div>--}}



    <div style="text-align: center; padding-bottom: 10px; font-size: 1.2em">
        <span><b>গেট পাসের তথ্য</b></span>
    </div>

    <table>
        <tr>
            <td style="width: 50%; text-align: left">
                <div>
                    <p><b>গেট পাস নং:</b> {{$gatepassInfo->gatepass_no}}</p>
                    <p><b>ডেলিভারি নং:</b> {{$gatepassInfo->deliverygroup->delivery_no}}</p>
                    <p><b>সময়:</b> {{ date('F d, Y', strtotime($gatepassInfo->gatepass_time)) }}</p>
                </div>
            </td>
            <td class="td-right-align" style="text-align: right; width: 50%">
                <div>
                    <p><b>পরিবহনের ধরন:</b> {{$gatepassInfo->transport['type']}}</p>
                    <p><b>পরিবহনের নম্বর:</b> {{$gatepassInfo->transport['number']}}</p>
                </div>
            </td>
        </tr>
    </table>

    @if(count($gatepassInfo->deliverygroup->deliveries))
        <div style="margin-top: 10px; text-align: center; padding-bottom: 10px; font-size: 1.2em">
            <span><b>গ্রাহকের তথ্য</b></span>
        </div>

        <table>
            <tr>
                <td style="width: 50%; text-align: left">
                    <div>
                        <div>
                            <p><b>নাম:</b> {{$gatepassInfo->deliverygroup->deliveries[0]->booking->client->name}}</p>
                        </div>
                    </div>
                </td>
                <td class="td-right-align" style="text-align: right; width: 50%">
                    <p><b>ফোন নম্বর:</b> {{$gatepassInfo->deliverygroup->deliveries[0]->booking->client->phone}}</p>
                </td>
            </tr>

        </table>
    @endif

    <div style="text-align: center; padding-bottom: 10px; font-size: 1.2em">
        <span><b>ডেলিভারি তথ্য</b></span>
    </div>

    <table class="bordertable">
        <thead>
        <tr>
            <th>আলুর ধরন</th>
            <th>SR/লট তালিকা</th>
            <th>পরিমাণ(ব্যাগ)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($gatepassInfo->deliverygroup->deliveries as $delivery)
            @foreach($delivery->deliveryitems as $deliveryitem)
                <tr>
                    <td>{{$deliveryitem->potato_type}}</td>
                    <td>{{$deliveryitem->srlot_no}}</td>
                    <td>{{$deliveryitem->quantity}}</td>
                </tr>
            @endforeach
        @endforeach
        <tr>
            <td colspan="2"><b>Total</b></td>
            <td>{{$gatepassInfo->deliverygroup->deliveries->sum(function ($deliveru){
    return $deliveru->deliveryitems->sum('quantity');
})}}</td>
        </tr>
        </tbody>
    </table>

@endsection
