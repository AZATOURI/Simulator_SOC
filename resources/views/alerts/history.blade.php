@extends('layouts.soc')

@section('content')
<h1>Audit History</h1>
<p class="muted">Traceability of all SOC analyst and admin actions.</p>

<div class="card">
    <table>
        <tr>
            <th>Alert</th>
            <th>User</th>
            <th>Action</th>
            <th>Old Status</th>
            <th>New Status</th>
            <th>Date</th>
        </tr>

        @forelse($logs as $log)
            <tr>
                <td>{{ $log->alert->title ?? 'Deleted Alert' }}</td>
                <td>{{ $log->user->name ?? 'System' }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->old_status ?? '-' }}</td>
                <td>{{ $log->new_status ?? '-' }}</td>
                <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No history found.</td>
            </tr>
        @endforelse
    </table>

    <div style="margin-top:20px;">
        {{ $logs->links() }}
    </div>
</div>
@endsection
