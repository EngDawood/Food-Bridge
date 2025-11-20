<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FoodBridge</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-primary-100 text-gray-900 min-h-screen flex flex-col">
    <header class="bg-primary-900 text-white">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="font-bold text-lg"><i class="fa-solid fa-bridge mr-2"></i>FoodBridge</a>
            <nav class="flex items-center gap-4 text-sm">
                <a href="/" class="hover:underline"><i class="fa-solid fa-house mr-1"></i>Home</a>

                @auth
                    @includeWhen(auth()->user()->role === 'admin', 'layouts.partials.nav-admin')
                    @includeWhen(auth()->user()->role === 'donor', 'layouts.partials.nav-donor')
                    @includeWhen(auth()->user()->role === 'beneficiary', 'layouts.partials.nav-beneficiary')
                    @includeWhen(auth()->user()->role === 'volunteer', 'layouts.partials.nav-volunteer')

                    <a href="/profile" class="hover:underline"><i class="fa-solid fa-user mr-1"></i>Profile</a>
                    <a href="/notifications" class="hover:underline"><i class="fa-solid fa-bell mr-1"></i>Notifications</a>
                @endauth

                @guest
                    <div class="flex items-center gap-2">
                        <div class="text-sm">
                            <a href="/login/admin" class="hover:underline">Admin</a>
                            <a href="/login/donor" class="hover:underline ml-2">Donor</a>
                            <a href="/login/beneficiary" class="hover:underline ml-2">Beneficiary</a>
                            <a href="/login/volunteer" class="hover:underline ml-2">Volunteer</a>
                        </div>
                    </div>
                    <a href="/register" class="px-3 py-1 rounded border border-white text-sm"><i class="fa-solid fa-user-plus mr-1"></i>Create account</a>
                @endguest

                @auth
                    <span class="opacity-90 text-sm">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-3 py-1 rounded border border-white text-sm"><i class="fa-solid fa-right-from-bracket mr-1"></i>Log out</button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8 flex-1 w-full">
        @yield('content')
    </main>

    <footer class="bg-primary-900 text-white">
        <div class="max-w-6xl mx-auto px-4 py-6 text-center">
            <p>© {{ date('Y') }} FoodBridge</p>
        </div>
    </footer>
</body>
</html>


