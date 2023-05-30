<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice of Payment</title>

    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{asset('/assets/images/logo/cpa-logo.png')}}" style="width:100%; max-width:300px;">
                            </td>

                            <td>
                                Order#: {{$product_order->product_order_id}}<br>
                                Created: {{date('d-m-Y',strtotime($product_order->payment_completed_date))}}<br>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Hydrography Department<br>
                                CTG Port Authority<br>

                            </td>

                            <td>
                                {{$customer->customer_organization}}<br>
                                {{$customer->customer_name}}<br>
                                {{$customer->email}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Payment Method
                </td>

                <td>
                     Transaction Ref#
                </td>
            </tr>

            <tr class="details">
                <td>
                    {{$payment_method}}
                </td>

                <td>
                    {{$transaction_reference}}
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Item
                </td>

                <td>
                    Price
                </td>
                <div style="display: none">
                    {{ $total = 0 }}
                </div>
            </tr>
            @foreach($product_order_details as $product_order_detail)
            <tr class="item">
                <td>
                   {{$product_order_detail->name}} ({{$product_order_detail->file_format_name}})
                </td>
                <td>
                    {{$product_order_detail->price}}
                </td>
                <div style="display: none">{{$total += $product_order_detail->price}}</div>
            </tr>
            @endforeach

            <tr class="total">
                <td></td>

                <td>
                   Total: {{$total}} BDT
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
