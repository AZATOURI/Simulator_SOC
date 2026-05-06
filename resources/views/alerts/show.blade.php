@extends('layouts.soc')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
    <div>
        <h1>Incident Investigation Workspace</h1>
        <p class="muted">Detection → Analysis → Containment → Reporting → Audit trail</p>
    </div>

    <a class="btn btn-dark" href="{{ route('alerts.index') }}">Back to Alerts</a>
</div>

<div class="mini-grid">
    <div>
        <div class="card">
            <h2 style="margin-top:0;">Incident Details</h2>

            <p><strong>Title:</strong> {{ $alert->title }}</p>
            <p><strong>Category:</strong> {{ $alert->category }}</p>
            <p>
                <strong>Severity:</strong>
                <span class="badge {{ strtolower($alert->severity) }}">{{ $alert->severity }}</span>
            </p>
            <p>
                <strong>Status:</strong>
                <span class="badge status-badge">{{ $alert->status }}</span>
            </p>
            <p><strong>Description:</strong> {{ $alert->description }}</p>
            <p><strong>Source IP:</strong> {{ $alert->source_ip }}</p>
            <p><strong>Target System:</strong> {{ $alert->target_system }}</p>
            <p><strong>Recommendation:</strong> {{ $alert->recommendation }}</p>
        </div>

        <div class="card">
            <h2 style="margin-top:0;">Raw Security Log</h2>
            <pre style="white-space:pre-wrap; color:#93c5fd;">{{ $alert->raw_log }}</pre>
        </div>

        <div class="card">
            <h2 style="margin-top:0;">Incident Timeline</h2>

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
    </div>

    <div>
        <div class="card">
            <h2 style="margin-top:0;">Analyst Workflow</h2>

            <div class="check-item">1. Review alert metadata and severity</div>
            <div class="check-item">2. Inspect source IP and target system</div>
            <div class="check-item">3. Add investigation note</div>
            <div class="check-item">4. Update incident status</div>
            <div class="check-item">5. Send incident report or escalate</div>
        </div>

        <div class="card">
            <h2 style="margin-top:0;">Update Incident Status</h2>

            <form method="POST" action="{{ route('alerts.status', $alert) }}">
                @csrf

                <label>Select new status</label>
                <select name="status">
                    <option value="New" @selected($alert->status === 'New')>New</option>
                    <option value="In Progress" @selected($alert->status === 'In Progress')>In Progress</option>
                    <option value="Resolved" @selected($alert->status === 'Resolved')>Resolved</option>
                    <option value="False Positive" @selected($alert->status === 'False Positive')>False Positive</option>
                </select>

                <button class="btn btn-warning">Apply Status</button>
            </form>
        </div>

        <div class="card">
            <h2 style="margin-top:0;">Add Investigation Note</h2>

            <form method="POST" action="{{ route('alerts.note', $alert) }}">
                @csrf

                <label>Analyst note</label>
                <textarea name="note" placeholder="Example: Suspicious source IP confirmed, reviewing authentication logs..."></textarea>

                <button class="btn btn-primary">Save Note</button>
            </form>
        </div>

        <div class="card">
            <h2 style="margin-top:0;">Send Incident Report</h2>

            <form method="POST" action="{{ route('alerts.report', $alert) }}">
                @csrf

                <label>Recipient</label>
                <select name="report_target">
                    <option value="SOC Manager">SOC Manager</option>
                    <option value="Team Lead">Team Lead</option>
                    <option value="CISO">CISO</option>
                </select>

                <label>Report summary</label>
                <textarea name="report_summary" placeholder="Short incident summary for management reporting..."></textarea>

                <button class="btn btn-success">Send Report</button>
            </form>
        </div>

        <div class="card">
            <h2 style="margin-top:0;">Escalation</h2>

            <form method="POST" action="{{ route('alerts.escalate', $alert) }}">
                @csrf
                <button class="btn btn-danger">Escalate to SOC Manager</button>
            </form>
        </div>

        @if(auth()->user()->role === 'admin')
            <div class="card">
                <h2 style="margin-top:0;">Admin Controls</h2>
                <a class="btn btn-warning" href="{{ route('alerts.edit', $alert) }}">Edit Alert</a>
            </div>
        @endif
    </div>
</div>
@endsection
