@extends('layouts.soc')

@section('content')
<div class="topbar">
    <div>
        <h1>Alert Investigation</h1>
        <p class="muted">SOC workflow: detection → analysis → status update → audit log.</p>
    </div>

    <a class="btn btn-dark" href="{{ route('alerts.index') }}">Back</a>
</div>

<div class="card">
    <h2>{{ $alert->title }}</h2>

    <p><strong>Category:</strong> {{ $alert->category }}</p>
    <p>
        <strong>Severity:</strong>
        <span class="badge {{ strtolower($alert->severity) }}">{{ $alert->severity }}</span>
    </p>
    <p>
        <strong>Status:</strong>
        <span class="badge status">{{ $alert->status }}</span>
    </p>
    <p><strong>Description:</strong> {{ $alert->description }}</p>
    <p><strong>Source IP:</strong> {{ $alert->source_ip }}</p>
    <p><strong>Target System:</strong> {{ $alert->target_system }}</p>
    <p><strong>Recommendation:</strong> {{ $alert->recommendation }}</p>
</div>

<div class="card">
    <h2>Raw Security Log</h2>
    <pre style="white-space:pre-wrap; color:#93c5fd;">{{ $alert->raw_log }}</pre>
</div>

<div class="card">
    <h2>Analyst Actions</h2>

    <form class="form-inline" method="POST" action="{{ route('alerts.status', $alert) }}">
        @csrf
        <input type="hidden" name="status" value="In Progress">
        <button class="btn btn-warning">Mark In Progress</button>
    </form>

    <form class="form-inline" method="POST" action="{{ route('alerts.status', $alert) }}">
        @csrf
        <input type="hidden" name="status" value="Resolved">
        <button class="btn btn-success">Mark Resolved</button>
    </form>

    <form class="form-inline" method="POST" action="{{ route('alerts.status', $alert) }}">
        @csrf
        <input type="hidden" name="status" value="False Positive">
        <button class="btn btn-primary">False Positive</button>
    </form>

    @if(auth()->user()->role === 'admin')
        <a class="btn btn-warning" href="{{ route('alerts.edit', $alert) }}">Edit</a>
    @endif
</div>

<div class="card">
    <h2>Audit Log</h2>

    <table>
        <tr>
            <th>User</th>
            <th>Action</th>
            <th>Old Status</th>
            <th>New Status</th>
            <th>Date</th>
        </tr>

        @forelse($alert->logs as $log)
            <tr>
                <td>{{ $log->user->name ?? 'System' }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->old_status ?? '-' }}</td>
                <td>{{ $log->new_status ?? '-' }}</td>
                <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No logs available.</td>
            </tr>
        @endforelse
    </table>
</div>
@endsection
