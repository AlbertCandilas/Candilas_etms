<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Management System - City Government of Davao</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .active-link {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 0.75rem;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-[#15803d] text-white flex flex-col fixed h-full">
            <div class="p-6 flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-lg">
                    <i class="bi bi-building text-2xl"></i>
                </div>
                <div>
                    <h1 class="font-bold leading-tight text-sm">City Government</h1>
                    <p class="text-[10px] opacity-80">of Davao</p>
                    <p class="text-[10px] font-medium mt-1">Time Management</p>
                </div>
            </div>

            <hr class="border-white/10 mx-4 mb-4">

            <nav class="flex-1 px-4 space-y-2">
                <a href="{{ route('employees.index') }}" 
                   class="flex items-center gap-3 p-3 hover:bg-white/10 transition-all rounded-xl {{ request()->routeIs('employees.*') ? 'active-link' : '' }}">
                    <i class="bi bi-people text-lg"></i>
                    <span class="text-sm font-semibold">Employees</span>
                </a>

                <a href="{{ route('attendance.index') }}" 
                   class="flex items-center gap-3 p-3 hover:bg-white/10 transition-all rounded-xl {{ request()->routeIs('attendance.*') ? 'active-link' : '' }}">
                    <i class="bi bi-clock text-lg"></i>
                    <span class="text-sm font-semibold">Attendance</span>
                </a>

                <a href="{{ route('payroll.index') }}" 
                   class="flex items-center gap-3 p-3 hover:bg-white/10 transition-all rounded-xl {{ request()->routeIs('payroll.*') ? 'active-link' : '' }}">
                    <i class="bi bi-currency-dollar text-lg"></i>
                    <span class="text-sm font-semibold">Payroll</span>
                </a>

                <a href="{{ route('leave-management.index') }}" 
                   class="flex items-center gap-3 p-3 hover:bg-white/10 transition-all rounded-xl {{ request()->routeIs('leave-management.*') ? 'active-link' : '' }}">
                    <i class="bi bi-file-earmark-text text-lg"></i>
                    <span class="text-sm font-semibold">Leave Management</span>
                </a>
            </nav>

            <div class="p-4 bg-black/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-black text-xs font-bold">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold truncate">{{ Auth::user()->name ?? 'Admin User' }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-[10px] text-white/60 hover:text-white">Sign Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 ml-64 p-8">
            <header class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">
                    @yield('header_title', 'Dashboard')
                </h2>
                <div class="text-sm text-gray-500">
                    {{ now()->format('l, F j, Y') }}
                </div>
            </header>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm p-6 min-h-[500px]">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>