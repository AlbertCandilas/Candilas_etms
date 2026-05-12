@extends('layouts.app')

@section('header_title', 'Attendance Terminal')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('attendance.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm transition-colors">
            <i class="bi bi-arrow-left"></i> Back to Logs
        </a>
    </div>

    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" class="space-y-4" id="attendanceForm">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="verified_by" value="{{ Auth::user()->administrator->id ?? $attendance->verified_by }}">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gray-50/80 border-b border-gray-100 px-6 py-3 flex justify-between items-center">
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Modify Log #{{ $attendance->id }}</h2>
                <span id="liveClock" class="text-xs font-mono text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100"></span>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Clock In Section --}}
                <div class="space-y-3">
                    <div class="flex justify-between items-center px-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Entry</span>
                        <button type="button" onclick="unlockField('time_in', this)" class="text-[10px] font-bold text-blue-500 hover:text-blue-700 transition-colors">
                            <i class="bi bi-pencil-square"></i> OVERRIDE
                        </button>
                    </div>
                    <button type="button" id="btn-time_in"
                        onclick="captureTime('time_in')"
                        @if($attendance->time_in) disabled @endif
                        class="w-full py-4 rounded-xl transition-all flex items-center justify-center gap-3 shadow-md 
                        {{ $attendance->time_in ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-[#15803d] text-white hover:bg-[#166534] active:scale-95' }}">
                        <i class="bi bi-box-arrow-in-right text-xl"></i>
                        <span class="font-bold">CLOCK IN</span>
                    </button>
                    <input type="time" name="time_in" id="time_in" value="{{ old('time_in', $attendance->time_in) }}" step="1"
                        class="w-full text-center font-mono text-lg py-2 border-2 rounded-lg outline-none transition-all cursor-pointer {{ $attendance->time_in ? 'bg-green-50 text-green-700 border-solid border-green-300 font-bold' : 'bg-gray-50 text-gray-400 border-dashed border-gray-200' }}" readonly>
                </div>

                {{-- Clock Out Section --}}
                <div class="space-y-3">
                    <div class="flex justify-between items-center px-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Exit</span>
                        <button type="button" onclick="unlockField('time_out', this)" class="text-[10px] font-bold text-blue-500 hover:text-blue-700 transition-colors">
                            <i class="bi bi-pencil-square"></i> OVERRIDE
                        </button>
                    </div>
                    <button type="button" id="btn-time_out"
                        onclick="captureTime('time_out')"
                        @if($attendance->time_out) disabled @endif
                        class="w-full py-4 rounded-xl transition-all flex items-center justify-center gap-3 shadow-md 
                        {{ $attendance->time_out ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gray-800 text-white hover:bg-gray-900 active:scale-95' }}">
                        <i class="bi bi-box-arrow-left text-xl"></i>
                        <span class="font-bold">CLOCK OUT</span>
                    </button>
                    <input type="time" name="time_out" id="time_out" value="{{ old('time_out', $attendance->time_out) }}" step="1"
                        class="w-full text-center font-mono text-lg py-2 border-2 rounded-lg outline-none transition-all cursor-pointer {{ $attendance->time_out ? 'bg-green-50 text-green-700 border-solid border-green-300 font-bold' : 'bg-gray-50 text-gray-400 border-dashed border-gray-200' }}" readonly>
                </div>
            </div>
        </div>

        {{-- Meta Data --}}
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Employee</label>
                <select name="employee_id" id="employee_id" required 
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-gray-50/50">
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('employee_id', $attendance->employee_id) == $emp->id ? 'selected' : '' }}>
                            {{ $emp->first_name }} {{ $emp->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Log Date</label>
                <input type="date" name="date" id="date" value="{{ old('date', $attendance->date) }}" required 
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50/50 outline-none">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Attendance Status</label>
                <select name="status_id" id="status_id" required 
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-gray-50/50">
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('status_id', $attendance->status_id) == $status->id ? 'selected' : '' }}>
                            {{ $status->status_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between px-2">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <p class="text-[11px] text-gray-400 font-medium">Editor: {{ Auth::user()->first_name }}</p>
            </div>
            <button type="submit" class="bg-[#15803d] hover:bg-[#166534] text-white font-bold py-3 px-8 rounded-xl shadow-lg flex items-center gap-2 transition-all active:scale-95">
                <i class="bi bi-check2-circle"></i> Update Record
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

    function unlockField(fieldId, overrideBtn) {
        const input = document.getElementById(fieldId);
        
        // 1. Remove readonly so the user can click it to open the time picker
        input.readOnly = false;
        
        // 2. Change visual style to "Active Edit" mode
        input.classList.remove('bg-green-50', 'text-green-700', 'border-green-300', 'bg-gray-50', 'text-gray-400', 'border-dashed');
        input.classList.add('bg-blue-50', 'text-blue-700', 'border-solid', 'border-blue-300', 'ring-2', 'ring-blue-100');
        
        // 3. Focus the input so the mobile keyboard or picker pops up immediately
        input.focus();

        // 4. Optionally hide the override button since it's already active
        overrideBtn.innerHTML = '<i class="bi bi-unlock"></i> EDITING...';
        overrideBtn.classList.replace('text-blue-500', 'text-orange-500');
    }

    function captureTime(fieldId) {
        const now = new Date();
        const timeString = now.toTimeString().split(' ')[0]; 
        const input = document.getElementById(fieldId);
        input.value = timeString;
        
        input.classList.remove('bg-gray-50', 'text-gray-400', 'border-dashed', 'border-gray-200', 'bg-blue-50', 'text-blue-700');
        input.classList.add('bg-green-50', 'text-green-700', 'border-solid', 'border-green-300', 'font-bold');
    }
</script>
@endsection