<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Checkout</h1>

    <!-- Display errors if validation fails -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Cart Summary -->
    <h2 class="mb-4">Your Cart</h2>
    @if(session('cart'))
        <table class="table table-bordered">
            <thead class="thead-light">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach(session('cart') as $id => $details)
                <tr>
                    <td>{{ $details['name'] }}</td>
                    <td>${{ number_format($details['price'], 2) }}</td>
                    <td>{{ $details['quantity'] }}</td>
                    <td>${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            Your cart is empty!
        </div>
    @endif

    <form action="{{route('items.process')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="address">Shipping Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="payment_method">Payment Method (Optional)</label>
            <select name="payment_method" id="payment_method" class="form-control">
                <option value="">Select Payment Method</option>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Submit Order</button>
    </form>

    <!-- Back to Cart Button -->
    <div class="mt-4">
        <a href="{{ route('cart.index') }}" class="btn btn-secondary">Back to Cart</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
