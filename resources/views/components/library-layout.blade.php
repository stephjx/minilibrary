@props(['header' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Library Management System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* CSS Reset for fixed positioning */
            html, body {
                margin: 0;
                padding: 0;
                height: 100%;
                overflow-x: hidden;
            }
            
            /* Ensure fixed positioning works correctly */
            .fixed-sidebar {
                position: fixed !important;
                left: 0 !important;
                top: 0 !important;
                width: 16rem !important;
                height: 100vh !important;
                z-index: 9999 !important;
                background-color: #0B3C5D !important;
            }
            
            /* Main content area */
            .main-content {
                margin-left: 16rem !important;
                min-height: 100vh !important;
                background-color: #F5F7FA !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="margin: 0; padding: 0;">
        <!-- Sidebar -->
        <aside class="fixed-sidebar">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-[#F4A300]">LibraryMS</h1>
                <p class="text-sm text-gray-300 mt-1">Management System</p>
            </div>
            
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-[#F4A300] text-[#0B3C5D]' : 'text-white hover:bg-[#1a4d6e]' }} flex items-center px-4 py-3 rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.index') ? 'bg-[#F4A300] text-[#0B3C5D]' : 'text-white hover:bg-[#1a4d6e]' }} flex items-center px-4 py-3 rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Students
                    </a>
                    
                    <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.index') ? 'bg-[#F4A300] text-[#0B3C5D]' : 'text-white hover:bg-[#1a4d6e]' }} flex items-center px-4 py-3 rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Books
                    </a>
                    
                    <a href="{{ route('authors.index') }}" class="{{ request()->routeIs('authors.index') ? 'bg-[#F4A300] text-[#0B3C5D]' : 'text-white hover:bg-[#1a4d6e]' }} flex items-center px-4 py-3 rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Authors
                    </a>
                    
                    <a href="{{ route('borrows.index') }}" class="{{ request()->routeIs('borrows.index') ? 'bg-[#F4A300] text-[#0B3C5D]' : 'text-white hover:bg-[#1a4d6e]' }} flex items-center px-4 py-3 rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Borrowing
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navbar -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div>
                        @if($header)
                            <h1 class="text-2xl font-semibold text-gray-900">{{ $header }}</h1>
                        @endif
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="flex items-center space-x-4">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6">
                <!-- Flash Messages -->
                @if (session()->has('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </body>
</html>
