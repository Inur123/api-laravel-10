<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Assuming Tailwind or your CSS file is included -->
</head>
<body class="bg-gray-100">
    <div class="container mx-auto">
        <h1 class="text-center text-2xl font-bold my-6">Register</h1>
        <form method="POST" action="{{ route('register') }}" class="max-w-md mx-auto bg-white p-6 rounded shadow-md">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-bold mb-2">Name:</label>
                <input type="text" name="name" id="name" required class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-bold mb-2">Email:</label>
                <input type="email" name="email" id="email" required class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-bold mb-2">Password:</label>
                <input type="password" name="password" id="password" required class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="date_of_birth" class="block text-sm font-bold mb-2">Date of Birth:</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="phone_number" class="block text-sm font-bold mb-2">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="institution_code" class="block text-sm font-bold mb-2">Institution Code (optional):</label>
                <input type="text" name="institution_code" id="institution_code" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="guardian_email" class="block text-sm font-bold mb-2">Guardian Email (optional):</label>
                <input type="email" name="guardian_email" id="guardian_email" class="w-full p-2 border rounded">
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded">Register</button>
        </form>
    </div>
</body>
</html>
