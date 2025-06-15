@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-6 flex items-center">
            <svg class="w-8 h-8 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Tambah Kasir
        </h1>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 text-sm p-4 rounded-lg mb-6">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.kasir.store') }}" class="bg-white p-6 rounded-xl shadow-md space-y-6">
            @csrf
            <!-- Nama -->
            <div>
                <label class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Nama
                </label>
                <input type="text" name="nama_user" value="{{ old('nama_user') }}" 
                       class="mt-1 block w-full border border-gray-200 rounded-lg p-3 focus:ring focus:ring-teal-300 focus:border-teal-500 outline-none transition duration-200"
                       placeholder="Masukkan nama kasir">
                @error('nama_user')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    Username
                </label>
                <input type="text" name="username" value="{{ old('username') }}" 
                       class="mt-1 block w-full border border-gray-200 rounded-lg p-3 focus:ring focus:ring-teal-300 focus:border-teal-500 outline-none transition duration-200"
                       placeholder="Masukkan username">
                @error('username')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1-.9-2-2-2s-2 .9-2 2v2h4v-2zm-2 4a2 2 0 110-4 2 2 0 010 4zm0 0v2m6-7h-2m2 7h-2m2-7v7M5 11h2m-2 7h2m-2-7v7"></path></svg>
                    Password
                </label>
                <input type="password" name="password" 
                       class="mt-1 block w-full border border-gray-200 rounded-lg p-3 focus:ring focus:ring-teal-300 focus:border-teal-500 outline-none transition duration-200"
                       placeholder="Masukkan password">
                @error('password')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Kasir
            </button>
        </form>
    </div>
@endsection