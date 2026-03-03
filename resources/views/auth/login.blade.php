<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LibraryMS - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-screen overflow-hidden">
    <div class="flex h-full">
        <!-- LEFT SIDE - Branding Panel -->
        <div class="w-1/2 bg-gradient-to-br from-[#0B3C5D] to-[#082C44] px-20 py-16 flex flex-col justify-center">
            <!-- Content Wrapper -->
            <div class="space-y-8">
                <!-- Logo and Decorative Element -->
                <div class="flex items-center gap-8">
                    <div class="w-12 h-12 bg-[#F4A300] rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-semibold tracking-wide text-white">LibraryMS</h2>
                    </div>
                    <!-- Inline Decorative Element -->
                    <div class="w-20 h-20 bg-[#F4A300] opacity-10 blur-xl rounded-full"></div>
                </div>

                <!-- Main Content -->
                <div class="space-y-8">
                    <div>
                        <h1 class="text-5xl font-bold text-white leading-tight mb-6">
                            Mini Library Management System
                        </h1>
                        
                        <p class="text-lg text-white opacity-90 leading-relaxed">
                            Efficiently manage books, students, and borrowing records with fine computation and inventory tracking.
                        </p>
                    </div>

                    <!-- Feature List -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 hover:opacity-80 transition-opacity">
                            <div class="w-2 h-2 bg-[#F4A300] rounded-full"></div>
                            <span class="text-lg text-white">Student Management</span>
                        </div>
                        <div class="flex items-center gap-4 hover:opacity-80 transition-opacity">
                            <div class="w-2 h-2 bg-[#F4A300] rounded-full"></div>
                            <span class="text-lg text-white">Book Inventory</span>
                        </div>
                        <div class="flex items-center gap-4 hover:opacity-80 transition-opacity">
                            <div class="w-2 h-2 bg-[#F4A300] rounded-full"></div>
                            <span class="text-lg text-white">Borrowing & Returns</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE - Login Panel -->
        <div class="w-1/2 bg-[#F5F7FA] flex items-center justify-center p-8">
            <!-- Login Card -->
            <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome back</h2>
                    <p class="text-gray-600">Sign in to your admin account</p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F4A300] focus:border-[#F4A300] transition-colors"
                            placeholder="admin@libraryms.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F4A300] focus:border-[#F4A300] transition-colors"
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            >
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="remember"
                                class="w-4 h-4 text-[#0B3C5D] border-gray-300 rounded focus:ring-[#0B3C5D]"
                            >
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <!-- Forgot Password Link -->
                    <div class="mb-6 text-right">
                        @if (Route::has('password.request'))
                            <a 
                                href="{{ route('password.request') }}" 
                                class="text-sm text-[#0B3C5D] hover:text-[#F4A300] transition-colors"
                            >
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit"
                        class="w-full bg-[#0B3C5D] hover:bg-[#082C44] text-white py-3 px-4 rounded-xl font-semibold transition duration-200"
                    >
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
</body>
</html>
