@extends('layouts.app')

@section('content')
<main>
    <div class="email-container">
        <div class="email-header">
            <h1 class="email-title">Apply for Leave</h1>
            <p>Fill out the form below to send a leave application to HR</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form class="email-form" id="leaveForm" method="POST" action="{{ route('leave.submit') }}">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="employeeName" class="required">Employee Name</label>
                    <input type="text" id="employeeName" name="employeeName" class="form-control" value="{{ session('user_name') }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="employeeId" class="required">Employee ID</label>
                    <input type="text" id="employeeId" name="employeeId" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="leaveType" class="required">Leave Type</label>
                    <select id="leaveType" name="leaveType" class="form-control" required>
                        <option value="">Select leave type</option>
                        <option value="annual">Annual Leave</option>
                        <option value="sick">Sick Leave</option>
                        <option value="personal">Personal Leave</option>
                        <option value="maternity">Maternity Leave</option>
                        <option value="paternity">Paternity Leave</option>
                        <option value="emergency">Emergency Leave</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="department" class="required">Department</label>
                    <input type="text" id="department" name="department" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="startDate" class="required">Start Date</label>
                    <input type="date" id="startDate" name="startDate" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="endDate" class="required">End Date</label>
                    <input type="date" id="endDate" name="endDate" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="dayType" class="required">Day Type</label>
                    <select id="dayType" name="dayType" class="form-control" required>
                        <option value="">Select</option>
                        <option value="full">Full Day</option>
                        <option value="half_am">Half Day (Morning)</option>
                        <option value="half_pm">Half Day (Afternoon)</option>
                    </select>
                </div>
            </div>

            <input type="hidden" id="totalDays" name="totalDays" value="1">

            <div class="form-group">
                <label for="reason" class="required">Reason for Leave</label>
                <textarea id="reason" name="reason" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="contactInfo">Contact Information During Leave</label>
                <input type="text" id="contactInfo" name="contactInfo" class="form-control">
            </div>

            <div class="form-group">
                <label for="handoverNotes">Work Handover Notes</label>
                <textarea id="handoverNotes" name="handoverNotes" class="form-control"></textarea>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-secondary" id="draftBtn">Save as Draft</button>
                <button type="submit" class="btn btn-primary">Submit Application</button>
            </div>
        </form>
    </div>
</main>
@endsection

@push('scripts')
<script>
    function updateDateTime() {
        const now = new Date();

        // Format time with hours, minutes, seconds
        document.getElementById('currentTime').innerText =
        now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', second:'2-digit'});

        // Format date (day/month/year)
        document.getElementById('currentDate').innerText =
        now.toLocaleDateString([], {year: 'numeric', month: 'long', day: 'numeric'});
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();

document.addEventListener('DOMContentLoaded', function() {
    const dayTypeSelect = document.getElementById('dayType');
    const totalDaysInput = document.getElementById('totalDays');

    dayTypeSelect.addEventListener('change', function() {
        if (this.value === 'full') {
            totalDaysInput.value = 1;
        } else if (this.value === 'half_am' || this.value === 'half_pm') {
            totalDaysInput.value = 0.5;
        }
    });

    // Draft button just alerts, does not block submit
    document.getElementById('draftBtn').addEventListener('click', function() {
        alert('Your leave application has been saved as a draft (not submitted).');
    });
});
</script>
@endpush
