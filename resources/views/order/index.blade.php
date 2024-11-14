<div style="margin-bottom: 20px;">
    <button onclick="window.history.back();" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Return Back
    </button>
</div>
@if($orders->isEmpty())
    <p style="text-align: center; font-size: 18px; color: #666;">
        You haven't made any orders yet.
    </p>
@else
<table style="width:100%; border-collapse: collapse; text-align: left;">
    <thead>
    <tr>
{{--        <th style="border-bottom: 1px solid #ddd; padding: 10px;">Order ID</th>--}}
        <th style="border-bottom: 1px solid #ddd; padding: 10px;">Order Date</th>
        <th style="border-bottom: 1px solid #ddd; padding: 10px;">Products name</th>
        <th style="border-bottom: 1px solid #ddd; padding: 10px;">Quantity</th>
        <th style="border-bottom: 1px solid #ddd; padding: 10px;">Payment Method</th>
        <th style="border-bottom: 1px solid #ddd; padding: 10px;">Address</th>
        <th style="border-bottom: 1px solid #ddd; padding: 10px;">Total Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
{{--            <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->id }}</td>--}}
            <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->created_at->format('M d, Y') }}</td>
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
            <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->address }}</td>
            <td style="border-bottom: 1px solid #ddd; padding: 10px;">${{ $order->total_price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif
