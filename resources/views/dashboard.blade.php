<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Store</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<header class="bg-white shadow p-4 flex justify-between items-center">
    <a href="{{route('dashboard')}}" class="text-2xl font-bold">E-Commerce Store</a>
    <!-- Search Form -->

    <form method="GET" action="/searchh" class="flex space-x-2">
        <input type="text" name="search" placeholder="Search products..." class="w-full px-4 py-2 border border-gray-300 rounded">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Search</button>
    </form>
    @auth()
        <nav class="flex space-x-4 items-center">
            <form method="POST" action="{{route('logout')}}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">Log out</button>
            </form>
            <a href="{{route('order.index')}}" class="bg-blue-500 text-white px-4 py-2 rounded">Order history</a>
            <a href="{{route('cart.index')}}" class="text-lg">Cart (<span id="cart-count">0</span>)</a>
        </nav>
    @endauth

    <!-- Navigation Links -->
    @guest()
        <nav class="flex space-x-4 items-center">
            <a href="{{route('cart.index')}}" class="text-lg">Cart (<span id="cart-count">0</span>)</a>

            <!-- Login and Register Buttons -->
            <a href="{{route('login')}}" class="bg-blue-500 text-white px-4 py-2 rounded">Login</a>
            <a href="{{route('register')}}" class="bg-green-500 text-white px-4 py-2 rounded">Register</a>
        </nav>
    @endguest
</header>

<main class="p-8">
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

    <h2 class="text-xl font-semibold mb-4">Products</h2>
    <div id="product-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                <div class="p-4">
                    <h3 class="text-lg font-bold mb-1">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500 mb-2">Type: {{ $product->type }}</p>
                    <p class="text-gray-700 mb-4">Description: {{ $product->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-semibold text-gray-900">${{ $product->price }}</span>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="number" name="quantity" value="1">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
</main>
<div class="mt-4 flex justify-center">
    {{ $products->links('pagination::tailwind') }}
</div>

</body>
</html>
