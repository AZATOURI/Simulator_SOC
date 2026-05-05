@extends('layouts.soc')

@section('content')
<div class="topbar">
    <div>
        <h1>SOC Dashboard</h1>
        <p class="muted">Real-time enterprise security alert monitoring.</p>
    </div>

    <form method="POST" action="{{ route('alerts.generate') }}">
        @csrf
        <button class="btn btn-danger">Generate Enterprise Attack</button>
    </form>
</div>

<div class="grid">
    <div class="card stat">
        <h3>Total Alerts</h3>
        <div class="number">{{ $total }}</div>
    </div>

    <div class="card stat">
        <h3>Critical</h3>
        <div class="number">{{ $critical }}</div>
    </div>

    <div class="card stat">
        <h3>In Progress</h3>
        <div class="number">{{ $inProgress }}</div>
    </div>

    <div class="card stat">
        <h3>Resolved</h3>
        <div class="number">{{ $resolved }}</div>
    </div>
</div>

<div class="card">
    <h2>Threat Overview</h2>
    <p class="muted">
        New: {{ $new }} |
        High: {{ $high }} |
        False Positive: {{ $falsePositive }}
    </p>
</div>

<div class="card">
    <h2>Latest Alerts</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Alert</th>
            <th>Category</th>
            <th>Severity</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        @forelse($latestAlerts as $alert)
            <tr>
                <td>#{{ $alert->id }}</td>
                <td>{{ $alert->title }}</td>
                <td>{{ $alert->category }}</td>
                <td>
                    <span class="badge {{ strtolower($alert->severity) }}">
                        {{ $alert->severity }}
                    </span>
                </td>
                <td><span class="badge status">{{ $alert->status }}</span></td>
                <td>
                    <a class="btn btn-primary" href="{{ route('alerts.show', $alert) }}">Investigate</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No alerts yet. Generate an attack to start the simulation.</td>
            </tr>
        @endforelse
    </table>
</div>
@endsection
