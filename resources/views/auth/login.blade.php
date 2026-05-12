<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Company X</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-custom {
            animation: spin 1s linear infinite;
            display: inline-block;
        }
    </style>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center font-sans">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-96 border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-[#15803d] tracking-tight">Company X</h1>
            <p class="text-gray-500 text-sm">Time Management System</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf
            
            @if($errors->any())
                <div class="mb-5 p-3 bg-red-50 border border-red-100 rounded-xl flex items-center gap-3 animate-pulse">
                    <i class="bi bi-exclamation-circle-fill text-red-500"></i>
                    <p class="text-red-700 text-xs font-semibold">{{ $errors->first() }}</p>
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-xs font-bold uppercase text-gray-400 mb-1 ml-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:border-[#15803d] transition-all" placeholder="name@companyx.com" required autofocus>
            </div>
            
            <div class="mb-6">
                <label class="block text-xs font-bold uppercase text-gray-400 mb-1 ml-1">Password</label>
                <input type="password" name="password" class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:border-[#15803d] transition-all" placeholder="••••••••" required>
            </div>

            <button type="submit" id="submitBtn" class="w-full bg-[#15803d] text-white font-bold py-3 rounded-xl hover:bg-[#166534] active:scale-[0.98] transition-all flex items-center justify-center gap-2 shadow-lg shadow-green-900/20">
                <span id="btnText">Sign In</span>
                <i id="spinner" class="bi bi-arrow-repeat text-xl hidden animate-spin-custom"></i>
            </button>
        </form>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const spinner = document.getElementById('spinner');

        loginForm.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            
            btnText.innerText = 'Authenticating...';
            spinner.classList.remove('hidden');
        });
    </script>
</body>
</html>