<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Define function immediately in head
        function toggleMobileMenu() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('mobile-overlay');

            if (sidebar && overlay) {
                const isActive = sidebar.classList.contains('active');

                if (isActive) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                } else {
                    sidebar.classList.add('active');
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            }
        }
    </script>

    <style>
        /* Premium Liquid Glass Effect - Monochrome */
        .glass-effect {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.15) 0%,
                rgba(255, 255, 255, 0.10) 50%,
                rgba(255, 255, 255, 0.08) 100%
            );
            backdrop-filter: blur(20px) saturate(150%);
            -webkit-backdrop-filter: blur(20px) saturate(150%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid rgba(255, 255, 255, 0.5);
            border-left: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow:
                0 8px 32px 0 rgba(0, 0, 0, 0.35),
                0 2px 8px 0 rgba(0, 0, 0, 0.15),
                inset 0 2px 4px rgba(255, 255, 255, 0.4),
                inset 0 -2px 4px rgba(0, 0, 0, 0.08),
                inset -2px 0 4px rgba(255, 255, 255, 0.3),
                inset 2px 0 4px rgba(0, 0, 0, 0.05);
        }

        .glass-effect-dark {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.12) 0%,
                rgba(255, 255, 255, 0.08) 50%,
                rgba(255, 255, 255, 0.05) 100%
            );
            backdrop-filter: blur(30px) saturate(180%) brightness(1.1);
            -webkit-backdrop-filter: blur(30px) saturate(180%) brightness(1.1);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-top: 2px solid rgba(255, 255, 255, 0.45);
            border-left: 1px solid rgba(255, 255, 255, 0.35);
            box-shadow:
                0 8px 32px 0 rgba(0, 0, 0, 0.4),
                0 4px 16px 0 rgba(0, 0, 0, 0.2),
                inset 0 2px 4px rgba(255, 255, 255, 0.3),
                inset 0 -2px 4px rgba(0, 0, 0, 0.1),
                inset -2px 0 4px rgba(255, 255, 255, 0.25),
                inset 2px 0 4px rgba(0, 0, 0, 0.08);
        }

        /* Enhanced Liquid Shimmer */
        .liquid-shimmer {
            position: relative;
            overflow: hidden;
        }

        .liquid-shimmer::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -100%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 30%,
                rgba(255, 255, 255, 0.15) 48%,
                rgba(255, 255, 255, 0.25) 50%,
                rgba(255, 255, 255, 0.15) 52%,
                transparent 70%
            );
            animation: liquidShimmer 4s infinite;
            pointer-events: none;
        }

        @keyframes liquidShimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        /* Enhanced Sidebar */
        .sidebar-item {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
        }

        .sidebar-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255, 255, 255, 0.15),
                rgba(255, 255, 255, 0.25),
                rgba(255, 255, 255, 0.15),
                transparent
            );
            transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-item:hover::before {
            left: 100%;
        }

        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(8px);
            box-shadow:
                0 4px 16px rgba(255, 255, 255, 0.2),
                inset 0 1px 2px rgba(255, 255, 255, 0.3);
        }

        .sidebar-item.active {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.25) 0%,
                rgba(255, 255, 255, 0.18) 100%
            );
            border-left: 3px solid rgba(255, 255, 255, 0.8);
            box-shadow:
                0 4px 20px rgba(255, 255, 255, 0.25),
                inset 0 1px 2px rgba(255, 255, 255, 0.35);
        }

        /* Monochrome Gradient Background */
        .animated-bg {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 25%, #1a1a1a 50%, #0f0f0f 75%, #1a1a1a 100%);
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glass Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(25px) saturate(160%);
            -webkit-backdrop-filter: blur(25px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-top: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow:
                0 4px 16px rgba(0, 0, 0, 0.3),
                inset 0 1px 2px rgba(255, 255, 255, 0.2);
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateY(-4px);
            box-shadow:
                0 12px 40px rgba(255, 255, 255, 0.15),
                inset 0 2px 4px rgba(255, 255, 255, 0.3);
        }

        /* Smooth Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.2));
            border-radius: 10px;
            border: 2px solid rgba(0, 0, 0, 0.2);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.4));
        }

        /* Toast Container */
        .toast-container {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-width: 420px;
            pointer-events: none;
        }

        .toast {
            pointer-events: auto;
            transform: translateX(calc(100% + 2rem));
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast.hide {
            transform: translateX(calc(100% + 2rem));
            opacity: 0;
        }

        /* Toast Types - Monochrome */
        .toast-success {
            background: linear-gradient(135deg, rgba(100, 100, 100, 0.95) 0%, rgba(80, 80, 80, 0.95) 100%);
        }

        .toast-error {
            background: linear-gradient(135deg, rgba(60, 60, 60, 0.95) 0%, rgba(40, 40, 40, 0.95) 100%);
        }

        .toast-info {
            background: linear-gradient(135deg, rgba(90, 90, 90, 0.95) 0%, rgba(70, 70, 70, 0.95) 100%);
        }

        .toast-warning {
            background: linear-gradient(135deg, rgba(110, 110, 110, 0.95) 0%, rgba(90, 90, 90, 0.95) 100%);
        }

        /* Progress Bar */
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: rgba(255, 255, 255, 0.4);
            animation: progressBar 5s linear forwards;
        }

        @keyframes progressBar {
            from { width: 100%; }
            to { width: 0%; }
        }

        /* Mobile Sidebar */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 85%;
            max-width: 320px;
            height: 100vh;
            z-index: 9998;
            transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.5);
        }

        .mobile-sidebar.active {
            left: 0;
        }

        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            z-index: 9997;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }

        .mobile-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        /* Mobile Bottom Navigation */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 50;
            padding-bottom: env(safe-area-inset-bottom);
        }

        @media (max-width: 640px) {
            .toast-container {
                top: 1rem;
                right: 1rem;
                left: 1rem;
                max-width: none;
            }
        }

        /* Safe area for notched devices */
        @supports (padding: max(0px)) {
            .mobile-bottom-nav {
                padding-bottom: max(env(safe-area-inset-bottom), 1rem);
            }
        }

        /* Prevent body scroll when sidebar is open */
        body.sidebar-open {
            overflow: hidden;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div id="toast-container" class="toast-container"></div>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay md:hidden"></div>

    <div class="flex h-screen overflow-hidden animated-bg">
        <!-- Desktop Sidebar -->
        <aside class="w-64 flex-shrink-0 hidden md:flex flex-col glass-effect-dark shadow-2xl liquid-shimmer">
            <div class="flex-1 flex flex-col p-6">
                <!-- Logo -->
                <div class="mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-gray-600 to-gray-800 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-white font-bold text-lg">Notes App</h2>
                            <p class="text-gray-300 text-xs">& Keuangan</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-2">
                    <a href="{{ route('dashboard') }}"
                       class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-xl text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('transactions.index') }}"
                       class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-xl text-white {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">Keuangan</span>
                    </a>

                    <a href="{{ route('notes.index') }}"
                       class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-xl text-white {{ request()->routeIs('notes.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span class="font-medium">Notes</span>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-xl text-white {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="font-medium">Profile</span>
                    </a>
                </nav>

                <!-- User Info -->
                <div class="mt-auto pt-6 border-t border-white/20">
                    <div class="glass-effect rounded-xl p-4 mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-gray-500 to-gray-700 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white font-medium text-sm truncate">{{ Auth::user()->name }}</p>
                                <p class="text-gray-300 text-xs truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-item w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-white hover:bg-red-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar -->
        <aside id="mobile-sidebar" class="mobile-sidebar md:hidden flex flex-col glass-effect-dark liquid-shimmer">
            <div class="flex-1 flex flex-col p-5 overflow-y-auto">
                <!-- Header with Logo & Close Button -->
                <div class="mb-6 flex items-center justify-between pb-4 border-b border-white/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-gray-600 to-gray-800 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-white font-bold text-base">Notes App</h2>
                            <p class="text-gray-300 text-xs">& Keuangan</p>
                        </div>
                    </div>
                    <button onclick="toggleMobileMenu()" class="p-2 rounded-lg hover:bg-white/10 transition-colors group">
                        <svg class="w-6 h-6 text-white group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- User Info -->
                <div class="mb-6">
                    <div class="glass-effect rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-700 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                                <p class="text-gray-300 text-xs truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-2">
                    <a href="{{ route('dashboard') }}"
                       class="sidebar-item flex items-center space-x-3 px-4 py-3.5 rounded-xl text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('transactions.index') }}"
                       class="sidebar-item flex items-center space-x-3 px-4 py-3.5 rounded-xl text-white {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">Keuangan</span>
                    </a>

                    <a href="{{ route('notes.index') }}"
                       class="sidebar-item flex items-center space-x-3 px-4 py-3.5 rounded-xl text-white {{ request()->routeIs('notes.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span class="font-medium">Notes</span>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="sidebar-item flex items-center space-x-3 px-4 py-3.5 rounded-xl text-white {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="font-medium">Profile</span>
                    </a>
                </nav>

                <!-- Logout -->
                <div class="mt-6 pt-4 border-t border-white/20">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-item w-full flex items-center space-x-3 px-4 py-3.5 rounded-xl text-white hover:bg-red-500/20">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto pb-20 md:pb-0">
            <!-- Mobile Header with Menu Button -->
            <div class="md:hidden sticky top-0 z-40 glass-effect-dark border-b border-white/20 px-4 py-3 mb-4">
                <div class="flex items-center justify-between">
                    <button onclick="toggleMobileMenu()" class="p-2 rounded-lg hover:bg-white/10 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-gray-600 to-gray-800 rounded-lg flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="text-white font-bold text-sm">Notes App</span>
                    </div>
                    <div class="w-10"></div> <!-- Spacer for centering -->
                </div>
            </div>

            <div class="container mx-auto px-3 py-0 md:px-8 md:py-8">
                <div class="glass-effect rounded-2xl shadow-2xl p-4 md:p-8 min-h-[calc(100vh-10rem)] md:min-h-[calc(100vh-4rem)] liquid-shimmer">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <!-- Mobile Bottom Navigation -->
        <div class="mobile-bottom-nav md:hidden">
            <div class="glass-effect-dark border-t border-white/20">
                <div class="flex justify-around items-center px-4 py-3">
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1
