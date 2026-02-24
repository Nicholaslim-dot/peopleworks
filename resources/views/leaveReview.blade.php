@extends('layouts.app')

@section('content')
<main>
    <div class="container mt-4">
        <div class="page-header">
            <h1 class="page-title">Leave Applications Review</h1>
            <p class="text-muted">HR/Admin can filter, search, and take action on leave applications.</p>
        </div>

        <!-- Success message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Filter Form -->
        <form method="GET" action="{{ route('leave.review') }}" class="mb-3">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <input type="text" name="employeeName" class="form-control" placeholder="Employee Name" value="{{ request('employeeName') }}">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" name="department" class="form-control" placeholder="Department" value="{{ request('department') }}">
                </div>
                <div class="form-group col-md-3">
                    <input type="date" name="startDate" class="form-control" value="{{ request('startDate') }}">
                </div>
                <div class="form-group col-md-3">
                    <input type="date" name="endDate" class="form-control" value="{{ request('endDate') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('leave.review') }}" class="btn btn-secondary">Reset</a>
        </form>

        <!-- Applications Table -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Department</th>
                    <th>Leave Type</th>
                    <th>Day Type</th>
                    <th>Total Days</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Contact Info</th>
                    <th>Handover Notes</th>
                    <th>Status</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td>{{ $app->id }}</td>
                        <td>{{ $app->employeeName }}</td>
                        <td>{{ $app->employeeId }}</td>
                        <td>{{ $app->department }}</td>
                        <td>{{ ucfirst($app->leaveType) }}</td>
                        <td>
                            @if($app->dayType === 'full')
                                Full Day
                            @elseif($app->dayType === 'half_am')
                                Half Day (Morning)
                            @elseif($app->dayType === 'half_pm')
                                Half Day (Afternoon)
                            @endif
                        </td>
                        <td>{{ $app->totalDays }}</td>
                        <td>{{ $app->startDate }}</td>
                        <td>{{ $app->endDate }}</td>
                        <td>{{ $app->reason }}</td>
                        <td>{{ $app->contactInfo ?? '-' }}</td>
                        <td>{{ $app->handoverNotes ?? '-' }}</td>
                        <td>
                            @if($app->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($app->status === 'accepted')
                                <span class="badge badge-success">Accepted</span>
                            @elseif($app->status === 'declined')
                                <span class="badge badge-danger">Declined</span>
                            @endif
                        </td>
                        <td>{{ $app->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($app->status === 'pending')
                                <form action="{{ route('leave.accept', $app->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                </form>
                                <form action="{{ route('leave.decline', $app->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                                </form>
                            @else
                                <em>No actions available</em>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" class="text-center">No leave applications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $applications->links() }}
    </div>
</main>
@endsection

