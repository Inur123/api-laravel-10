<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Date of Birth</th>
                    <th class="px-4 py-2">Phone Number</th>
                    <th class="px-4 py-2">Institution Code</th>
                    <th class="px-4 py-2">Guardian Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                    <tr>
                        <td class="border px-4 py-2">{{ $user['name'] }}</td>
                        <td class="border px-4 py-2">{{ $user['email'] }}</td>
                        <td class="border px-4 py-2">{{ $user['date_of_birth'] }}</td>
                        <td class="border px-4 py-2">{{ $user['phone_number'] }}</td>
                        <td class="border px-4 py-2">{{ $user['institution_code'] }}</td>
                        <td class="border px-4 py-2">{{ $user['guardian_email'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
