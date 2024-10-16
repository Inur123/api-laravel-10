<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body class="bg-gray-100">
    <div class="container mx-auto">
        <h1 class="text-center text-2xl font-bold my-6">Login</h1>
        <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto bg-white p-6 rounded shadow-md">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-bold mb-2">Email:</label>
                <input type="email" name="email" id="email" required class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-bold mb-2">Password:</label>
                <input type="password" name="password" id="password" required class="w-full p-2 border rounded">
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded">Login</button>
        </form>
    </div>
</body>
</html>
