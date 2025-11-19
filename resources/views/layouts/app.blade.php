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
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="font-bold text-lg md:text-xl"><i class="fa-solid fa-bridge mr-2"></i>FoodBridge</a>

                <!-- Mobile menu button -->
                <button id="mobile-menu-toggle" class="lg:hidden text-white p-2 hover:bg-primary-800 rounded-lg transition-colors" aria-label="Toggle menu">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <!-- Desktop navigation -->
                <nav class="hidden lg:flex items-center gap-4 text-sm">
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
                            <button class="px-3 py-2 min-h-[44px] rounded border border-white text-sm"><i class="fa-solid fa-right-from-bracket mr-1"></i>Log out</button>
                        </form>
                    @endauth
                </nav>
            </div>

            <!-- Mobile navigation menu -->
            <nav id="mobile-menu" class="hidden lg:hidden mt-4 pb-2 border-t border-primary-800 pt-4">
                <div class="flex flex-col gap-3 text-base">
                    <a href="/" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-house mr-2"></i>Home</a>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="/admin" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-gauge mr-2"></i>Dashboard</a>
                            <a href="/admin/users" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-users mr-2"></i>Users</a>
                            <a href="/admin/transactions" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-exchange-alt mr-2"></i>Transactions</a>
                            <a href="/admin/reports" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-file-alt mr-2"></i>Reports</a>
                            <a href="/admin/feedback" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-comments mr-2"></i>Feedback</a>
                        @endif

                        @if(auth()->user()->role === 'donor')
                            <a href="/donations" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-hand-holding-heart mr-2"></i>My Donations</a>
                        @endif

                        @if(auth()->user()->role === 'beneficiary')
                            <a href="/requests" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-clipboard-list mr-2"></i>My Requests</a>
                        @endif

                        @if(auth()->user()->role === 'volunteer')
                            <a href="/volunteer/my-tasks" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-truck mr-2"></i>My Tasks</a>
                            <a href="/volunteer/available" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-list mr-2"></i>Available Tasks</a>
                        @endif

                        <a href="/profile" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-user mr-2"></i>Profile</a>
                        <a href="/notifications" class="hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-bell mr-2"></i>Notifications</a>

                        <div class="border-t border-primary-800 pt-3 mt-2">
                            <div class="px-3 py-2 opacity-90 text-sm mb-2">{{ auth()->user()->name }}</div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors"><i class="fa-solid fa-right-from-bracket mr-2"></i>Log out</button>
                            </form>
                        </div>
                    @endauth

                    @guest
                        <div class="border-t border-primary-800 pt-3">
                            <div class="px-3 py-2 text-sm text-primary-200 mb-2">Login as:</div>
                            <a href="/login/admin" class="block hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors mb-1">Admin</a>
                            <a href="/login/donor" class="block hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors mb-1">Donor</a>
                            <a href="/login/beneficiary" class="block hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors mb-1">Beneficiary</a>
                            <a href="/login/volunteer" class="block hover:bg-primary-800 px-3 py-3 rounded-lg transition-colors mb-3">Volunteer</a>
                            <a href="/register" class="block text-center bg-accent-500 hover:brightness-95 px-3 py-3 rounded-lg transition-all"><i class="fa-solid fa-user-plus mr-2"></i>Create account</a>
                        </div>
                    @endguest
                </div>
            </nav>
        </div>
    </header>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-toggle')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            const icon = this.querySelector('i');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                menu.classList.add('hidden');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    </script>

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


