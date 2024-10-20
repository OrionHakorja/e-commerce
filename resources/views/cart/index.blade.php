<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="mb-4">Your Cart</h1>

    @if(session('cart'))
        <table class="table table-bordered">
            <thead class="thead-light">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach(session('cart') as $id => $details)
                <tr>
                    <td>{{ $details['name'] }}</td>
                    <td>${{ number_format($details['price'], 2) }}</td>
                    <td>
                        <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="form-control" style="width: 80px; display: inline-block;">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                    <td>${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                    <td>
                        <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Order Now Button -->
        <div class="text-right mb-4">

    <a href="{{route('order.shipping')}}" type="submit" class="btn btn-success">Order Now</a>

            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline ml-2">
                @csrf
                <button type="submit" class="btn btn-warning">Clear Cart</button>
            </form>
        </div>

    @else
        <div class="alert alert-info">
            Your cart is empty!
        </div>
    @endif

    <!-- Back to Home Button -->
    <div class="mt-4">
        <a href="{{ url('/') }}" class="btn btn-secondary">Back to Home</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
