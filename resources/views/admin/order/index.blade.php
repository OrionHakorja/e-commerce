<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Store</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<header class="bg-white shadow p-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold">E-Commerce Store (Role: Admin)</a>
    <nav class="flex space-x-4 items-center">
        <form method="GET" action="{{ route('admin.orders.search') }}" class="flex space-x-2 items-center">
            <input type="text" name="search" placeholder="Search orders..." class="px-4 py-2 border border-gray-300 rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Search</button>
        </form>
        <a href="{{ route('admin.dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Return to dashboard</a>
        <form method="POST" action="{{ route('logout') }}" class="inline-block">
            @csrf
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Log out</button>
        </form>
    </nav>
</header>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M14.348 14.849a1 1 0 01-1.415 0L10 11.415l-2.933 2.933a1 1 0 01-1.415-1.415l2.933-2.933-2.933-2.933a1 1 0 011.415-1.415l2.933 2.933 2.933-2.933a1 1 0 011.415 1.415L11.415 10l2.933 2.933a1 1 0 010 1.415z"/>
                </svg>
            </span>
        </div>
    @endif
@if($orders->isEmpty())
    <p style="text-align: center; font-size: 18px; color: #666;">
       No orders have been made.
    </p>
@else
    <table style="width:100%; border-collapse: collapse; text-align: left;">
        <thead>
        <tr>
            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Order ID</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Order Date</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px;">User's name</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px;">User's email</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px;">User's address</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Products name</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Quantity</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Payment Method</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Total Price</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Status</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Delete order</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                            <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->id }}</td>
                <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->created_at->format('M d, Y') }}</td>
                <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->name}}</td>
                <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->email}}</td>
                <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->address}}</td>
                <td style="border-bottom: 1px solid #ddd; padding: 10px;">
                    <ul style="list-style-type: none; padding: 0;">
                        @foreach($order->items as $item)
                            <li>{{ $item->product_name }}</li>

                        @endforeach
                    </ul>
                </td>
                <td style="border-bottom: 1px solid #ddd; padding: 10px;">
                    <ul style="list-style-type: none; padding: 0;">
                        @foreach($order->items as $item)
                            <li>{{ $item->quantity }}</li>
                        @endforeach
                    </ul>
                </td>
                <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->payment_method }}</td>
                <td style="border-bottom: 1px solid #ddd; padding: 10px;">${{ $order->total_price }}</td>
                <td style="border-bottom: 1px solid #ddd; padding: 10px;">
                    <form action="{{route('admin.orders.status', $order->id)}}" method="POST" style="display: flex; align-items: center; gap: 10px;">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-0" style="flex-grow: 1;">
                            <select name="status" class="form-select form-select-sm" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ced4da;">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Update</button>
                    </form>
                </td>
                <td style="border-bottom: 1px solid #ddd; padding: 10px;">
                    <form action="{{ route('order.delete', $order->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this order?');">
                            Delete
                        </button>
                    </form>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-4 flex justify-center">
        {{ $orders->links('pagination::tailwind') }}
    </div>
@endif
</body>
