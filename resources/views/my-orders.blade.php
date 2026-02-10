<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tecci | Your Shopping Cart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="{{ asset('checkoutstyle.css') }}" />
  <link rel="stylesheet" href="{{ asset('contactstyle.css') }}" />
  <!--Google Font-->
  <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        .orders-container { max-width: 1000px; margin: 50px auto; padding: 0 20px; }
        .order-card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 6px solid #005baf;
        }
        .order-info h3 { color: #03315b; margin-bottom: 5px; }
        .order-meta { color: #777; font-size: 0.9rem; }
        .order-total { font-weight: bold; font-size: 1.2rem; color: #333; }
        .order-status {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-placed { background: #e3f2fd; color: #005baf; }
        .status-delivered { background: #e8f5e9; color: #2e7d32; }
        
        .btn-view {
            background: #03315b;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-view:hover { background: #005baf; }
    </style>
</head>
<body>

    <header class="main-header">
        <div class="container nav-container">
            <a href="/" class="logo">
                <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
                <span class="logo-text">TECCI</span>
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="orders-container">
        <h2 style="margin-bottom: 30px; color: #03315b;">Your Order History</h2>

        @forelse($orders as $order)
            <div class="order-card">
                <div class="order-info">
                    <h3>Order #{{ $order->id }}</h3>
                    <div class="order-meta">
                        Placed on {{ $order->created_at->format('d M, Y') }}
                    </div>
                    <div class="order-status {{ $order->status == 'Delivered' ? 'status-delivered' : 'status-placed' }}">
                        {{ $order->status }}
                    </div>
                </div>

                <div class="order-summary-right" style="text-align: right;">
                    <div class="order-total" style="margin-bottom: 10px;">
                        £{{ number_format($order->total_price, 2) }}
                    </div>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn-view">
                        View Details & Review
                    </a>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 50px;">
                <i class="fa-solid fa-box-open" style="font-size: 3rem; color: #ccc;"></i>
                <p style="margin-top: 20px; color: #666;">You haven't placed any orders yet.</p>
                <a href="{{ route('products.index') }}" style="color: #005baf;">Go shopping!</a>
            </div>
        @endforelse
    </div>

</body>
</html>