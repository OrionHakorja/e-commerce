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
    <h1 class="text-2xl font-bold">E-Commerce Store(Role:Admin)</h1>
    <nav class="flex space-x-4 items-center">
        <a href="{{ route('admin.dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 text-white px-4 py-2 rounded">Log out</button>
        </form>
    </nav>
</header>

<main class="p-8">
    <h2 class="text-xl font-semibold mb-4">Add a product</h2>
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
        <form method="POST" action="{{route('admin.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Product Name</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product name" required>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">Product Image</label>
                <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product image" required>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">Price</label>
                <input type="number" id="price" name="price" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter price" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product description" required></textarea>
            </div>


            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-bold mb-2">Product Type</label>
                <input type="text" id="stock" name="type" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product type" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add Product</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>
