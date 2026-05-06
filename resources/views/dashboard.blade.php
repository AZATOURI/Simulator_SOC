@extends('layouts.soc')

@section('content')
@php
    $activeIncidents = $new + $inProgress;
@endphp

<h1>Security Operations Center</h1>
<p class="muted">Real-time threat monitoring and SOC analyst response dashboard.</p>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
    <div></div>
    <form method="POST" action="{{ route('alerts.generate') }}">
        @csrf
        <button class="btn btn-danger">Generate Enterprise Attack</button>
    </form>
</div>

<div class="grid">
    <div class="card">
        <div class="stat-title">Active Incidents</div>
        <div class="stat-number">{{ $activeIncidents }}</div>
        <div class="small-trend negative">↑ +2 from last hour</div>
    </div>

    <div class="card">
        <div class="stat-title">Threats Detected</div>
        <div class="stat-number">{{ $total }}</div>
        <div class="small-trend positive">↓ -5% from yesterday</div>
    </div>

    <div class="card">
        <div class="stat-title">Critical Alerts</div>
        <div class="stat-number">{{ $critical }}</div>
        <div class="small-trend negative">Requires immediate review</div>
    </div>

    <div class="card">
        <div class="stat-title">Resolved Cases</div>
        <div class="stat-number">{{ $resolved }}</div>
        <div class="small-trend positive">Workflow completed</div>
    </div>
</div>

<div class="mini-grid">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="margin:0;">Recent Incidents</h2>
            <a class="btn btn-primary" href="{{ route('alerts.index') }}">View All</a>
        </div>

        <div style="margin-top:18px;">
            <table>
                <tr>
                    <th>Incident ID</th>
                    <th>Title</th>
                    <th>Severity</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>

                @forelse($latestAlerts as $alert)
                    <tr>
                        <td>#{{ $alert->id }}</td>
                        <td>{{ $alert->title }}</td>
                        <td>
                            <span class="badge {{ strtolower($alert->severity) }}">
                                {{ $alert->severity }}
                            </span>
                        </td>
                        <td>
                            <span class="badge status-badge">
                                {{ $alert->status }}
                            </span>
                        </td>
                        <td>{{ $alert->created_at->format('H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No incidents yet.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>

    <div class="card">
        <h2 style="margin-top:0;">Live Threat Feed</h2>

        <div class="scroll-feed">
            @forelse($latestAlerts as $alert)
                <div class="feed-item">
                    <div>
                        <div style="font-weight:bold;">{{ $alert->category }}</div>
                        <div style="color:#94a3b8; font-size:13px;">{{ $alert->title }}</div>
                    </div>
                    <div>
                        <span class="badge {{ strtolower($alert->severity) }}">
                            {{ $alert->severity }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="feed-item">
                    <div>No live feed available.</div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="card">
    <h2 style="margin-top:0;">Threat Detection Overview</h2>

    <div class="mini-grid">
        <div>
            <div class="check-item">🟢 New Alerts: {{ $new }}</div>
            <div class="check-item">🟠 In Progress: {{ $inProgress }}</div>
            <div class="check-item">🔵 Resolved: {{ $resolved }}</div>
            <div class="check-item">⚪ False Positive: {{ $falsePositive }}</div>
        </div>

        <div>
            <div class="check-item">🔥 High Severity: {{ $high }}</div>
            <div class="check-item">🚨 Critical: {{ $critical }}</div>
            <div class="check-item">🛡 SOC Posture: Monitored</div>
            <div class="check-item">📡 Status Feed: Active</div>
        </div>
    </div>
</div>
@endsection
