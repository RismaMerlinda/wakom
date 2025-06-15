@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800 flex items-center">
                <svg class="w-8 h-8 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Kelola Waiter
            </h1>
            <a href="{{ route('admin.waiter.create') }}" 
               class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition duration-200 shadow-md hover:shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Waiter
            </a>
        </div>

        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 text-sm p-4 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 text-sm p-4 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        @forelse($waiter as $user)
            <div class="bg-white p-6 rounded-xl shadow-md mb-4 flex flex-col sm:flex-row justify-between items-center hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center mb-4 sm:mb-0">
                    <svg class="w-6 h-6 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $user->nama_user }}</h3>
                        <p class="text-sm text-gray-500">Username: {{ $user->username }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.waiter.destroy', $user->id) }}" method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus waiter ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-200 shadow-sm hover:shadow-md flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus
                    </button>
                </form>
            </div>
        @empty
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <p class="text-gray-600 text-sm flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Belum ada waiter.
                </p>
            </div>
        @endforelse
    </div>
@endsection