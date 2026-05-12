@extends('layouts.app')

@section('header_title', 'Attendance Terminal')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('attendance.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm transition-colors">
            <i class="bi bi-arrow-left"></i> Back to Logs
        </a>
    </div>

    <form action="{{ route('attendance.store') }}" method="POST" class="space-y-4" id="attendanceForm">
        @csrf
        
        {{-- Auto-Verification: Hidden Field --}}
        <input type="hidden" name="verified_by" value="{{ Auth::user()->administrator->id ?? '' }}">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gray-50/80 border-b border-gray-100 px-6 py-3 flex justify-between items-center">
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Time Capture</h2>
                <span id="liveClock" class="text-xs font-mono text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100"></span>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Clock In Section --}}
                <div class="space-y-3">
                    <div class="flex justify-between items-center px-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Entry</span>
                    </div>
                    <button type="button" id="btn-time_in" onclick="captureTime('time_in')" 
                        class="w-full py-4 bg-[#15803d] text-white rounded-xl hover:bg-[#166534] active:scale-95 transition-all flex items-center justify-center gap-3 shadow-md">
                        <i class="bi bi-box-arrow-in-right text-xl"></i>
                        <span class="font-bold">CLOCK IN</span>
                    </button>
                    <input type="time" name="time_in" id="time_in" value="{{ old('time_in') }}" step="1"
                        class="w-full text-center font-mono text-lg py-2 border-2 border-solid border-gray-200 rounded-lg bg-white text-gray-700 outline-none transition-all cursor-pointer focus:border-green-500 focus:ring-4 focus:ring-green-50" placeholder="--:--:--">
                </div>

                {{-- Clock Out Section --}}
                <div class="space-y-3">
                    <div class="flex justify-between items-center px-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Exit</span>
                    </div>
                    <button type="button" id="btn-time_out" onclick="captureTime('time_out')" 
                        class="w-full py-4 bg-gray-800 text-white rounded-xl hover:bg-gray-900 active:scale-95 transition-all flex items-center justify-center gap-3 shadow-md">
                        <i class="bi bi-box-arrow-left text-xl"></i>
                        <span class="font-bold">CLOCK OUT</span>
                    </button>
                    <input type="time" name="time_out" id="time_out" value="{{ old('time_out') }}" step="1"
                        class="w-full text-center font-mono text-lg py-2 border-2 border-solid border-gray-200 rounded-lg bg-white text-gray-700 outline-none transition-all cursor-pointer focus:border-gray-800 focus:ring-4 focus:ring-gray-100" placeholder="--:--:--">
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Employee</label>
                <select name="employee_id" id="employee_id" required 
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-gray-50/50">
                    <option value="" disabled selected>Select Staff</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                            {{ $emp->first_name }} {{ $emp->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Log Date</label>
                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required 
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50/50 outline-none">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Attendance Status</label>
                <select name="status_id" id="status_id" required 
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-gray-50/50">
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                            {{ $status->status_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between px-2">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <p class="text-[11px] text-gray-400 font-medium">
                    Session: {{ Auth::user()->first_name }} (Admin)
                </p>
            </div>
            <button type="submit" class="bg-[#15803d] hover:bg-[#166534] text-white font-bold py-3 px-8 rounded-xl shadow-lg flex items-center gap-2 transition-all active:scale-95">
                <i class="bi bi-check2-circle"></i> Confirm Entry
            </button>
        </div>
    </form>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const clockElement = document.getElementById('liveClock');
        if(clockElement) clockElement.textContent = now.toLocaleTimeString();
    }
    setInterval(updateClock, 1000);
    updateClock();

    function captureTime(fieldId) {
        const now = new Date();
        const timeString = now.toTimeString().split(' ')[0]; 
        
        const input = document.getElementById(fieldId);
        input.value = timeString;
        
        // Restore transition visual feedback
        input.classList.remove('border-gray-200');
        input.classList.add('bg-green-50', 'text-green-700', 'border-green-300', 'font-bold');
        
        // Brief highlight effect then settle
        setTimeout(() => {
            input.classList.remove('bg-green-50');
        }, 1000);

        if(fieldId === 'time_in') {
            const statusSelect = document.getElementById('status_id');
            for (let i = 0; i < statusSelect.options.length; i++) {
                if (statusSelect.options[i].text.toLowerCase().includes('present')) {
                    statusSelect.selectedIndex = i;
                    break;
                }
            }
        }
    }
</script>
@endsection