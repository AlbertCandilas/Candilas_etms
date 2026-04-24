<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ETMS - City Government of Davao</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-green-600 text-white flex flex-col shadow-lg">

        <div class="p-6 flex items-center space-x-3">
            <div class="w-10 h-10 bg-white/20 rounded-md flex items-center justify-center font-bold">
                D
            </div>

            <div>
                <h1 class="font-bold leading-tight">
                    City Government<br>
                    <span class="text-xs font-normal">of Davao</span>
                </h1>
                <p class="text-[10px] text-green-200 uppercase mt-1 tracking-wider">
                    Time Management
                </p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-2">

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all
               {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'hover:bg-white/10 text-green-100' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span>Dashboard</span>
            </a>

            {{-- Attendance --}}
            <a href="{{ route('admin.attendance') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all
               {{ request()->routeIs('admin.attendance') ? 'bg-white/20' : 'hover:bg-white/10 text-green-100' }}">
                <i data-lucide="clock" class="w-5 h-5"></i>
                <span>Attendance</span>
            </a>

            {{-- Employees --}}
            <a href="{{ route('admin.employees.index') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all
               {{ request()->routeIs('admin.employees.*') ? 'bg-white/20' : 'hover:bg-white/10 text-green-100' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span>Employees</span>
            </a>

            {{-- Payroll --}}
            <a href="{{ route('admin.payroll') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all
               {{ request()->routeIs('admin.payroll') ? 'bg-white/20' : 'hover:bg-white/10 text-green-100' }}">
                <i data-lucide="credit-card" class="w-5 h-5"></i>
                <span>Payroll</span>
            </a>

            {{-- Leave --}}
            <a href="{{ route('admin.leave') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all
               {{ request()->routeIs('admin.leave') ? 'bg-white/20' : 'hover:bg-white/10 text-green-100' }}">
                <i data-lucide="calendar-off" class="w-5 h-5"></i>
                <span>Leave Management</span>
            </a>

        </nav>

        {{-- USER --}}
        <div class="p-4 border-t border-green-500/50">
            <div class="flex items-center space-x-3 px-2">
                <div class="w-8 h-8 bg-green-700 rounded-full flex items-center justify-center text-xs font-bold border border-white/30">
                    A
                </div>
                <div>
                    <p class="text-xs font-bold">Admin User</p>
                    <p class="text-[10px] text-green-200">Admin</p>
                </div>
            </div>
        </div>

    </aside>

    {{-- MAIN AREA --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        <header class="bg-white border-b px-8 py-4 flex justify-between items-center shadow-sm">
            <h2 class="text-xl font-bold text-gray-800">
                @yield('header_title', 'Dashboard Overview')
            </h2>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </main>

    </div>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>