<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Warkom</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Import Poppins font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 to-teal-50 flex items-center justify-center min-h-screen px-4 font-poppins antialiased">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg w-full max-w-md transform transition-all duration-300">
        <!-- Logo or Brand -->
        <div class="flex justify-center mb-6">
            <svg class="w-12 h-12 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-semibold text-center text-gray-800 mb-6">Create Your Warkom Account</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 text-sm p-3 rounded-lg mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="/register" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <div class="mt-1 relative">
                    <input type="text" name="nama_user" value="{{ old('nama_user') }}" 
                           class="block w-full border border-gray-200 rounded-lg p-3 pl-10 focus:ring focus:ring-teal-300 focus:border-teal-500 outline-none transition duration-200"
                           placeholder="Enter your full name" required>
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                @error('nama_user') 
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <div class="mt-1 relative">
                    <input type="text" name="username" value="{{ old('username') }}" 
                           class="block w-full border border-gray-200 rounded-lg p-3 pl-10 focus:ring focus:ring-teal-300 focus:border-teal-500 outline-none transition duration-200"
                           placeholder="Enter your username" required>
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                @error('username') 
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1 relative">
                    <input type="password" name="password" 
                           class="block w-full border border-gray-200 rounded-lg p-3 pl-10 focus:ring focus:ring-teal-300 focus:border-teal-500 outline-none transition duration-200"
                           placeholder="Enter your password" required>
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1-.9-2-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2h4a2 2 0 002-2v-1m0-3v4m6-6h4a2 2 0 012 2v4a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4a2 2 0 012-2z"></path>
                    </svg>
                </div>
                @error('password') 
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <div class="mt-1 relative">
                    <input type="password" name="password_confirmation" 
                           class="block w-full border border-gray-200 rounded-lg p-3 pl-10 focus:ring focus:ring-teal-300 focus:border-teal-500 outline-none transition duration-200"
                           placeholder="Confirm your password" required>
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1-.9-2-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2h4a2 2 0 002-2v-1m0-3v4m6-6h4a2 2 0 012 2v4a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4a2 2 0 012-2z"></path>
                    </svg>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition duration-200 shadow-md hover:shadow-lg">
                    Create Account
                </button>
            </div>

            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">Sudah punya akun? 
                    <a href="/login" class="text-teal-600 hover:text-teal-700 hover:underline font-medium">Login di sini</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>