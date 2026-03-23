<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Orders - Tecci</title>
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Signika', sans-serif;
            padding: 20px;
            background: #ffffff;
        }
        
        .invoice {
            max-width: 800px;
            margin: 0 auto 40px;
            page-break-after: always;
            border: 1px solid #ddd;
            padding: 40px;
        }
        
        .invoice:last-child {
            page-break-after: auto;
        }
        
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 3px solid #03315b;
            padding-bottom: 20px;
        }
        
        .company-info h1 {
            color: #03315b;
            font-size: 32px;
            margin-bottom: 5px;
        }
        
        .company-info p {
            color: #666;
            font-size: 14px;
        }
        
        .invoice-meta {
            text-align: right;
        }
        
        .invoice-meta h2 {
            color: #03315b;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .invoice-meta p {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .order-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .detail-section h3 {
            color: #03315b;
            font-size: 16px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .detail-section p {
            color: #333;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .items-table thead {
            background: #f8f9fa;
        }
        
        .items-table th {
            padding: 12px;
            text-align: left;
            color: #03315b;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            border-bottom: 2px solid #03315b;
        }
        
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            color: #333;
            font-size: 14px;
        }
        
        .items-table tbody tr:last-child td {
            border-bottom: 2px solid #03315b;
        }
        
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        
        .total-row {
            display: flex;
            justify-content: flex-end;
            gap: 50px;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .total-row.grand-total {
            font-size: 20px;
            font-weight: 700;
            color: #03315b;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #03315b;
        }
        
        .footer-note {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .invoice {
                border: none;
                margin-bottom: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<!-- Print Button (hidden when printing) -->
<div class="no-print" style="text-align: center; margin-bottom: 30px;">
    <button onclick="window.print()" style="background: #03315b; color: white; padding: 12px 30px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; font-family: 'Signika', sans-serif;">
        🖨️ Print Invoices
    </button>
</div>

@foreach($orders as $order)
<div class="invoice">
    <div class="invoice-header">
        <div class="company-info">
            <h1>TECCI</h1>
            <p>Smart Tech at Smart Prices</p>
            <p>Birmingham, B4 7ET</p>
            <p>0121 555 0198</p>
        </div>
        <div class="invoice-meta">
            <h2>INVOICE</h2>
            <p><strong>Order #:</strong> {{ $order->id }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
            <p><strong>Status:</strong> {{ $order->status }}</p>
        </div>
    </div>

    <div class="order-details">
        <div class="detail-section">
            <h3>Bill To</h3>
            <p><strong>{{ $order->user->name ?? 'Guest Customer' }}</strong></p>
            <p>{{ $order->user->email ?? 'N/A' }}</p>
            @if($order->phone)
                <p>{{ $order->phone }}</p>
            @endif
        </div>

        @if($order->address_line1)
        <div class="detail-section">
            <h3>Ship To</h3>
            <p>{{ $order->first_name }} {{ $order->last_name }}</p>
            <p>{{ $order->address_line1 }}</p>
            @if($order->address_line2)
                <p>{{ $order->address_line2 }}</p>
            @endif
            <p>{{ $order->city }}, {{ $order->postcode }}</p>
            <p>{{ $order->country }}</p>
        </div>
        @endif
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Product</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: right;">Unit Price</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">£{{ number_format($item->price, 2) }}</td>
                <td style="text-align: right;">£{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row grand-total">
            <span>TOTAL:</span>
            <span>£{{ number_format($order->total_price, 2) }}</span>
        </div>
    </div>

    <div class="footer-note">
        <p>Thank you for your business!</p>
        <p>For any queries, contact us at Tecci_Queries@net.com</p>
    </div>
</div>
@endforeach

<script>
    // Auto-print on load (optional)
    // window.onload = function() {
    //     window.print();
    // };
</script>

</body>
</html>
