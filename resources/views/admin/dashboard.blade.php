@extends('layouts.app') {{-- Siguraduhin na may layouts/app.blade.php ka --}}

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
            <p class="mt-1 text-sm text-gray-600">Real-time update ng iyong Employee Tracking Management System.</p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            {{-- Total Employees Card --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center space-x-4">
                <div class="p-3 bg-blue-50 text-blue-500 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Employees</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalEmployees ?? 0 }}</h3>
                </div>
            </div>

            {{-- Present Today Card --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center space-x-4">
                <div class="p-3 bg-green-50 text-green-500 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Present Today</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $presentToday ?? 0 }}</h3>
                </div>
            </div>

            {{-- Pending Leaves Card --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center space-x-4">
                <div class="p-3 bg-orange-50 text-orange-500 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pending Leaves</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $pendingLeaves ?? 0 }}</h3>
                </div>
            </div>

            {{-- Monthly Payroll Card --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center space-x-4">
                <div class="p-3 bg-purple-50 text-purple-500 rounded-lg">
                    <span class="text-xl font-bold">₱</span>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Monthly Payroll</p>
                    <h3 class="text-2xl font-bold text-gray-800">₱{{ number_format($monthlyPayroll ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>

        {{-- Placeholder for Table or Chart --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
            <p class="text-gray-500">Magsimulang mag-add ng employees para makita ang analytics dito.</p>
        </div>

    </div>
</div>
